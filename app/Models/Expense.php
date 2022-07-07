<?php

namespace App\Models;

use App\Enums\Category;
use App\Enums\Frequency;
use App\Enums\DueDate;
use DateTimeInterface;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;

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

    /**
     * @param  \Illuminate\Support\Carbon  $today
     *
     * @return bool
     * @throws \Exception
     */
    public function applicable(Carbon $today): bool
    {
        // check day of month
        return $this->applicableDayOfMonth($today) && $this->applicableMonthOfYear($today);
    }

    /**
     * @throws \Exception
     */
    protected function applicableDayOfMonth(Carbon $today): bool
    {
        if ($this->start > $today) {
            return false;
        } elseif ($this->end instanceof DateTimeInterface && $this->end < $today) {
            return false;
        }
        $now = clone $today;
        switch ($this->due_date) {
            case DueDate::Daily:
                return true;
            case DueDate::FirstOfMonth:
                return $today->startOfDay() == $now->firstOfMonth();
            case DueDate::FirstWorkingDayOfMonth:
                if ($now->firstOfMonth()->isWeekend()) {
                    $now->firstOfMonth(1);
                }
                return $now == $today->startOfDay();
            case DueDate::LastDayOfMonth:
                return $today->startOfDay() == $now->lastOfMonth();
            case DueDate::LastWorkingDayOfMonth:
                if ($now->lastOfMonth()->isWeekend()) {
                    $now->lastOfMonth(5);
                }
                return $today->startOfDay() == $now;
            case DueDate::FirstDayOfYear:
                return $now->firstOfYear() == $today->startOfDay();
            case DueDate::Monday:
            case DueDate::Tuesday:
            case DueDate::Wednesday:
            case DueDate::Thursday:
            case DueDate::Friday:
            case DueDate::Saturday:
            case DueDate::Sunday:
                return $today->format('l') == $this->due_date->name;
            case DueDate::DateInMonth:
                if (preg_match('/\d+/', $this->due_date_meta, $matched)) {
                    $now = Carbon::createFromDate($today->year, $today->month,
                        $matched[0]);
                    while ($now->isWeekend()) {
                        $now->addDay();
                    }
                    return $now->startOfDay() == $today->startOfDay();
                }
                throw new Exception('Due Date is ' . $this->due_date->name . ' but no sensible due date meta was set.');
        }

        return false;
    }

    public function applicableMonthOfYear(Carbon $today): bool
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

                while ($start->format('Y-m') <= $today->format('Y-m')) {
                    if ($start->format('Y-m') == $today->format('Y-m')) {
                        return true;
                    }

                    $start->addMonths($numberOf);
                }

                return false;
            default:
                return true;
        }
    }

    public function getCost(): float
    {
        return $this->category === Category::Income ? abs($this->amount) : abs($this->amount) * -1;
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

    public function applyTransfer(&$balance): float
    {
        return $balance -= $this->getCost();
    }

}
