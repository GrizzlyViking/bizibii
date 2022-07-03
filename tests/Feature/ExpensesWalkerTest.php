<?php

namespace Tests\Feature;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\Account;
use App\Models\Expense;
use App\Models\User;
use App\Services\ExpensesWalker;
use App\Services\GraphExpenses;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * @property $user
 */
class ExpensesWalkerTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::find(1);
        $this->user->accounts()->save(Account::factory()->make([
            'balance' => 0,
        ]));
    }

    /** @test */
    public function walk_through_one_month_with_one_expense()
    {
        /** @var Account $account */
        $account = $this->user->accounts->first();

        $account->expenses()->create([
            'category' => Category::House,
            'description' => 'Mortgage',
            'frequency' => Frequency::Monthly,
            'due_date' => DueDate::FirstWorkingDayOfMonth,
            'amount' => 5800.00
        ]);

        $walker = new ExpensesWalker($this->user, Carbon::createFromDate(2022, 1,1), Carbon::createFromDate(2022, 1,31));

        $complete = $walker->process()->graphBalance($account, ExpensesWalker::DAILY);

        $this->assertInstanceOf(Collection::class, $complete);
        $this->assertEquals($account->balance, $complete->get('2022-01-02'));
        $this->assertEquals(($account->balance - 5800.0), $complete->get('2022-01-03'));
    }

    /** @test */
    public function walk_through_one_year_with_expenses_and_income()
    {
        /** @var Account $account */
        $account = $this->user->accounts->first();

        $account->expenses()->create([
            'category' => Category::Income,
            'description' => 'Wages from aller',
            'frequency' => Frequency::Monthly,
            'due_date' => DueDate::LastWorkingDayOfMonth,
            'start' => '2021-11-01',
            'amount' => 33633.00
        ]);

        $account->expenses()->create([
            'category' => Category::House,
            'description' => 'Food and drink',
            'frequency' => Frequency::Daily,
            'due_date' => DueDate::Daily,
            'start' => '2021-11-01',
            'amount' => 350.00
        ]);

        $account->expenses()->create([
            'category' => Category::House,
            'description' => 'Mortgage',
            'frequency' => Frequency::Monthly,
            'due_date' => DueDate::FirstWorkingDayOfMonth,
            'amount' => 5800.00
        ]);

        $account->expenses()->create([
            'category' => Category::House,
            'description' => 'Mortgage',
            'frequency' => Frequency::Every3rdMonth,
            'start' => '2021-03-01',
            'due_date' => DueDate::FirstWorkingDayOfMonth,
            'amount' => 8600.00
        ]);

        $account->expenses()->create([
            'category' => Category::Utilities,
            'description' => 'Electricity',
            'frequency' => Frequency::Monthly,
            'start' => '2021-03-01',
            'due_date' => DueDate::FirstWorkingDayOfMonth,
            'amount' => 2600.00
        ]);

        Expense::create([
            'account_id' => $account->id,
            'category' => Category::House,
            'description' => 'various',
            'frequency' => Frequency::Monthly,
            'start' => '2021-04-01',
            'due_date' => DueDate::FirstWorkingDayOfMonth,
            'amount' => 10500.00
        ]);

        Expense::create([
            'account_id' => $account->id,
            'category' => Category::DayToDayConsumption,
            'description' => Category::DayToDayConsumption->value,
            'frequency' => Frequency::Monthly,
            'start' => '2021-04-01',
            'due_date' => DueDate::LastDayOfMonth,
            'amount' => 12500.00
        ]);

        $walker = new ExpensesWalker($this->user, Carbon::createFromDate(2022, 1,1), Carbon::createFromDate(2022, 12,31), 0);

        $complete = $walker->process()->graphBalance($account, ExpensesWalker::MONTHLY);

        $this->assertInstanceOf(Collection::class, $complete);
        $this->assertCount(12, $complete);


        $this->assertEquals(4883.0, $complete->get('2022-01'));
        $this->assertEquals(0, $complete->get('2022-02'));
        $this->assertEquals(-4717.0, $complete->get('2022-03'));
        $this->assertEquals(3749.0, $complete->get('2022-11'));

    }

}
