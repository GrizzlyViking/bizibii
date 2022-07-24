<?php

namespace App\Models;

use App\Enums\Category;
use App\Enums\Frequency;
use App\Enums\DueDate;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use DateTimeInterface;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $account_id
 * @property int $transfer_to_account_id
 * @property string $description
 * @property Category $category
 * @property float $amount
 * @property boolean $applied
 * @property DueDate $due_date
 * @property string $due_date_meta
 * @property Frequency $frequency
 * @property Carbon $start
 * @property Carbon $end
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property \App\Models\User $user
 * @property \App\Models\Account $account
 * @property \App\Models\Account $transferToAccount;
 * @property CarbonInterface $date_to_check;
 * @property \Illuminate\Support\Collection<\App\Models\Reality> $checkpoints;
 *
 * @method static self create(array $fillable)
 * @method static self updateOrInsert(array $criteria, array $payload)
 *
 */
class Expense extends Model
{
    use HasFactory;

    protected $dates = [
        'start',
        'end',
    ];

    protected $casts = [
        'applied'   => 'boolean',
        'category'  => Category::class,
        'frequency' => Frequency::class,
        'due_date'  => DueDate::class,
    ];

    protected $fillable = [
        'account_id',
        'transfer_to_account_id',
        'description',
        'category',
        'frequency',
        'due_date',
        'due_date_meta',
        'amount',
        'applied',
        'start',
        'end',
    ];

    protected $with = ['account', 'user'];

    private CarbonInterface $date_to_check;

    public function user(): Relation
    {
        return $this->hasOneThrough(
            User::class,
            Account::class,
            'user_id',
            'id',
            'account_id'
        );
    }

    public function account(): Relation
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function transferToAccount(): Relation
    {
        return $this->belongsTo(Account::class, 'transfer_to_account_id', 'id');
    }

    public function checkpoints(): Relation
    {
        return $this->morphMany(Reality::class, 'checkpointable');
    }

    public function setDateToCheck(CarbonInterface|string $date): self
    {
        if ($date instanceof CarbonInterface) {
            $this->date_to_check = (clone $date)->toImmutable();
        } else {
            $this->date_to_check = CarbonImmutable::parse($date);
        }

        return $this;
    }

    /**
     * Check day of month
     *
     * @param  \Illuminate\Support\Carbon  $today
     *
     * @return bool
     * @throws \Exception
     */
    public function applicable(Carbon $today): bool
    {
        $this->setDateToCheck($today);

        if (($checkpoint = $this->getApplicableCheckpoints()) !== false) {
            return $checkpoint->isNotEmpty();
        }

        return $this->applicableDayOfMonth() && $this->applicableMonthOfYear();
    }

    /**
     * @throws \Exception
     */
    protected function applicableDayOfMonth(): bool
    {
        if ($this->start > $this->date_to_check) {
            return false;
        } elseif ($this->end instanceof DateTimeInterface && $this->end < $this->date_to_check) {
            return false;
        }
        $now = (clone $this->date_to_check)->toMutable();
        switch ($this->due_date) {
            case DueDate::Daily:
                return true;
            case DueDate::FirstOfMonth:
                return $this->date_to_check->isSameDay($this->date_to_check->firstOfMonth());
            case DueDate::FirstWorkingDayOfMonth:
                if ($now->firstOfMonth()->isWeekend()) {
                    $now->firstOfMonth(1);
                }
                return $this->date_to_check->isSameDay($now);
            case DueDate::LastDayOfMonth:
                return $this->date_to_check->isSameDay($now->lastOfMonth());
            case DueDate::LastWorkingDayOfMonth:
                if ($now->lastOfMonth()->isWeekend()) {
                    $now->lastOfMonth(5);
                }
                return $this->date_to_check->isSameDay($now);
            case DueDate::FirstDayOfYear:
                return $this->date_to_check->isSameDay($now->firstOfYear());
            case DueDate::Monday:
            case DueDate::Tuesday:
            case DueDate::Wednesday:
            case DueDate::Thursday:
            case DueDate::Friday:
            case DueDate::Saturday:
            case DueDate::Sunday:
                return $this->date_to_check->format('l') == $this->due_date->name;
            case DueDate::DateInMonth:
                if (preg_match('/\d+/', $this->due_date_meta, $matched)) {
                    $now = Carbon::createFromDate($this->date_to_check->year, $this->date_to_check->month,
                        $matched[0]);
                    while ($now->isWeekend()) {
                        $now->addDay();
                    }
                    return $this->date_to_check->isSameDay($now);
                }
                throw new Exception('Due Date is ' . $this->due_date->name . ' but no sensible due date meta was set.');
        }

        return false;
    }

    public function applicableMonthOfYear(): bool
    {
        switch ($this->frequency) {
            // month interval
            case Frequency::Every3rdMonth:
            case Frequency::Every4thMonth:
            case Frequency::Every6thMonth:
                // how frequent
                [
                    $numberOf,
                    $lengthOf,
                ] = $this->parseFrequency($this->frequency);

                $start = clone $this->start;

                while ($start->format('Y-m') <= $this->date_to_check->format('Y-m')) {
                    if ($start->format('Y-m') == $this->date_to_check->format('Y-m')) {
                        return true;
                    }

                    $start->addMonths($numberOf);
                }

                return false;
            default:
                return true;
        }
    }

    public function getCost(): int
    {
        $amount = $this->amount;
        if (($checkpoint = $this->getApplicableCheckpoints()) !== false) {
            $amount = $checkpoint->isNotEmpty() ? $checkpoint->last()->amount : 0;
        }
        return $this->category === Category::Income ? abs($amount) : abs($amount) * -1;
    }

    /**
     * @param  \App\Enums\Frequency  $frequency
     *
     * @return array<string>
     */
    private function parseFrequency(Frequency $frequency): array
    {
        preg_match('/^every\s(\d+?).*.\s(\w+)$/', $frequency->value, $matched);

        unset($matched[0]);

        return array_values($matched);
    }

    public function applyCost(&$balance): float
    {
        if ($this->category->equals(Category::DayToDayConsumption)) {
            if ($balance >= ($this->getCost() * -1)) {
                return $balance += $this->getCost();
            } elseif ($balance < ($this->getCost() * -1) && $balance >= ($this->getCost() / 2 * -1)) {
                return $balance = 0;
            } else {
                return $balance + ($this->getCost() / 2);
            }
        }

        return $balance += $this->getCost();
    }

    public function applyTransfer(&$balance): int
    {
        return $balance -= $this->getCost();
    }

    protected function getApplicableCheckpoints(): Collection|bool
    {
        if ($this->checkpoints->isEmpty()) {
            return false;
        }

        // check day of month
        if ($this->frequency->equals(Frequency::Monthly)) {
            $checkpoints = $this->checkpoints->filter(fn(Reality $reality) => $reality->registered_date->between($this->date_to_check->startOfMonth()->format('Y-m-d'), $this->date_to_check->endOfMonth()->format('Y-m-d')));
            // if checkpoint is within the relevant month
            if ($checkpoints->isNotEmpty()) {
                // then it is checkpoint date that is used.
                return $checkpoints->filter(fn (Reality $reality) => $reality->checkpoint_date == $this->date_to_check->format('Y-m-d'));
            }
        } elseif ($this->frequency->equals(Frequency::Weekly)) {
            $checkpoints = $this->checkpoints->filter(fn(Reality $reality) => $reality->registered_date->between($this->date_to_check->startOfWeek(), $this->date_to_check->endOfWeek()));
            if ($checkpoints->isNotEmpty()) {
                return $checkpoints->filter(fn (Reality $reality) => $reality->checkpoint_date == $this->date_to_check->format('Y-m-d'));
            }
        } elseif ($this->frequency->equals(Frequency::Daily)) {
            $checkpoints = $this->checkpoints->filter(fn(Reality $reality) => $reality->registered_date->isSameDay($this->date_to_check));
            if ($checkpoints->isNotEmpty()) {
                return $checkpoints;
            }
        }

        // if checkpoints exist but date fall outside relevant interval then false is returned
        return false;
    }

}
