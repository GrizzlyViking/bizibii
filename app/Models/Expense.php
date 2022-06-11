<?php

namespace App\Models;

use App\Enums\Category;
use App\Enums\Frequency;
use App\Enums\DueDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $bank_account_id
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
 * @property \App\Models\BankAccount $account
 *
 * @method static self create(array $fillable)
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
        'bank_account_id',
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

    public function user()
    {
        return $this->hasOneThrough(User::class, BankAccount::class);
    }

    public function account()
    {
        return $this->belongsTo(BankAccount::class);
    }

    /**
     * @param  \Illuminate\Support\Carbon  $today
     *
     * @return void
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
                throw new \Exception('Due Date is ' . $this->due_date->name . ' but no sensible due date meta was set.');
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
        return $this->category === Category::Income ? abs($this->amount) * -1 : abs($this->amount);
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

}
