<?php

namespace Tests\Feature;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\Account;
use App\Models\Expense;
use App\Models\User;
use App\Services\ExpensesWalker;
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
            'category'    => Category::House,
            'description' => 'Mortgage',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 5800.00,
        ]);

        $walker = new ExpensesWalker($this->user, Carbon::createFromDate(2022, 1, 1), Carbon::createFromDate(2022, 1, 31));

        $complete = $walker->process()->graphBalance($account);

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
            'category'    => Category::Income,
            'description' => 'Wages from aller',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::LastWorkingDayOfMonth,
            'start'       => '2021-11-01',
            'amount'      => 33633.00,
        ]);

        $account->expenses()->create([
            'category'    => Category::House,
            'description' => 'Food and drink',
            'frequency'   => Frequency::Daily,
            'due_date'    => DueDate::Daily,
            'start'       => '2021-11-01',
            'amount'      => 350.00,
        ]);

        $account->expenses()->create([
            'category'    => Category::House,
            'description' => 'Mortgage',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 5800.00,
        ]);

        $account->expenses()->create([
            'category'    => Category::House,
            'description' => 'Mortgage',
            'frequency'   => Frequency::Every3rdMonth,
            'start'       => '2021-03-01',
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 8600.00,
        ]);

        $account->expenses()->create([
            'category'    => Category::Utilities,
            'description' => 'Electricity',
            'frequency'   => Frequency::Monthly,
            'start'       => '2021-03-01',
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 2600.00,
        ]);

        Expense::create([
            'account_id'  => $account->id,
            'category'    => Category::House,
            'description' => 'various',
            'frequency'   => Frequency::Monthly,
            'start'       => '2021-04-01',
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 10500.00,
        ]);

        Expense::create([
            'account_id'  => $account->id,
            'category'    => Category::DayToDayConsumption,
            'description' => Category::DayToDayConsumption->value,
            'frequency'   => Frequency::Monthly,
            'start'       => '2021-04-01',
            'due_date'    => DueDate::LastDayOfMonth,
            'amount'      => 12500.00,
        ]);

        $walker = new ExpensesWalker($this->user, Carbon::createFromDate(2022, 1, 1), Carbon::createFromDate(2022, 12, 31), 0);

        $complete = $walker->process()->graphBalanceMonthly($account);

        $this->assertInstanceOf(Collection::class, $complete);
        $this->assertCount(12, $complete);


        $this->assertEquals(4883.0, $complete->get('2022-01'));
        $this->assertEquals(0, $complete->get('2022-02'));
        $this->assertEquals(-4717.0, $complete->get('2022-03'));
        $this->assertEquals(3749.0, $complete->get('2022-11'));
    }

    /** @test */
    public function transfer_between_accounts()
    {
        /** @var Account $accountFrom */
        $accountFrom = Account::factory()->create([
            'user_id' => $this->user->id,
            'balance' => 10000,
        ]);
        /** @var Account $accountTo */
        $accountTo = Account::factory()->create([
            'user_id' => $this->user->id,
            'balance' => 100,
        ]);

        Expense::create([
            'account_id'             => $accountFrom->id,
            'transfer_to_account_id' => $accountTo->id,
            'category'               => Category::Transfer,
            'description'            => 'various',
            'frequency'              => Frequency::Monthly,
            'start'                  => '2021-04-01',
            'due_date'               => DueDate::LastDayOfMonth,
            'amount'                 => 9500.00,
        ]);

        $walker = (new ExpensesWalker(
            $this->user,
            Carbon::parse('2022-01-01'),
            Carbon::parse('2022-03-31')
        ))->process();

        $balanceFrom = $walker->graphBalance($accountFrom);
        $this->assertEquals(10000, $balanceFrom->get('2022-01-30'));
        $this->assertEquals(500, $balanceFrom->get('2022-01-31'));
        $this->assertEquals(-9000, $balanceFrom->get('2022-02-28'));

        $balanceTo = $walker->graphBalance($accountTo);
        $this->assertEquals(100, $balanceTo->get('2022-01-30'));
        $this->assertEquals(9600, $balanceTo->get('2022-01-31'));
        $this->assertEquals(19100.0, $balanceTo->get('2022-02-28'));

        $balanceTo = $walker->graphBalanceMonthly($accountTo);
        $this->assertEquals(9600, $balanceTo->get('2022-01'));
        $this->assertEquals(19100, $balanceTo->get('2022-02'));
        $this->assertEquals(28600.0, $balanceTo->get('2022-03'));
    }


    /** @test */
    public function chart_expenses()
    {
        /** @var Account $account */
        $account = $this->user->accounts->first();

        $account->expenses()->create([
            'category'    => Category::Income,
            'description' => 'Wages from aller',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::LastWorkingDayOfMonth,
            'start'       => '2021-11-01',
            'amount'      => 33633.00,
        ]);

        $account->expenses()->create([
            'category'    => Category::House,
            'description' => 'Mortgage',
            'frequency'   => Frequency::Monthly,
            'start'       => '2021-03-01',
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 5600.00,
        ]);

        $account->expenses()->create([
            'category'    => Category::House,
            'description' => 'Mortgage',
            'frequency'   => Frequency::Every3rdMonth,
            'start'       => '2021-03-01',
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 8600.00,
        ]);

        $walker = (new ExpensesWalker(
            $this->user,
            Carbon::parse('2022-01-01'),
            Carbon::parse('2022-12-31')
        ))->process();

        $expenses = $walker->graphExpensesMonthly($account);
        $this->assertEquals(5600.0, $expenses->get('2022-01'));
        $this->assertEquals(14200.0, $expenses->get('2022-03'));
        $this->assertEquals(5600.0, $expenses->get('2022-11'));
        $this->assertEquals(14200.0, $expenses->get('2022-12'));
    }


    /** @test */
    public function graph_income()
    {
        /** @var Account $account */
        $account = $this->user->accounts->first();

        $account->expenses()->create([
            'category'    => Category::Income,
            'description' => 'Wages from aller',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::LastWorkingDayOfMonth,
            'start'       => '2021-11-01',
            'amount'      => 33633.00,
        ]);

        $account->expenses()->create([
            'category'    => Category::House,
            'description' => 'Mortgage',
            'frequency'   => Frequency::Monthly,
            'start'       => '2021-03-01',
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 5600.00,
        ]);

        $account->expenses()->create([
            'category'    => Category::House,
            'description' => 'Mortgage',
            'frequency'   => Frequency::Every3rdMonth,
            'start'       => '2021-03-01',
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 8600.00,
        ]);

        $walker = (new ExpensesWalker(
            $this->user,
            Carbon::parse('2022-01-01'),
            Carbon::parse('2022-12-31')
        ))->process();

        $expenses = $walker->graphIncomeMonthly($account);
        $this->assertEquals(33633.0, $expenses->get('2022-01'));
        $this->assertEquals(33633.0, $expenses->get('2022-12'));
    }

    /** @test */
    public function checkpoints_for_balance_replace_estimated_balance()
    {
        /** @var Account $account */
        $account = $this->user->accounts()->create([
            'name'        => 'checkpoint test',
            'description' => 'checkpoint test',
            'balance'     => 10000,
        ]);

        $account->checkpoints()->create([
            'registered_date' => '2022-02-07',
            'amount'      => -500.02,
        ]);

        $account->expenses()->create([
            'category'    => Category::Income,
            'description' => 'Wages from aller',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::LastWorkingDayOfMonth,
            'start'       => '2021-11-01',
            'amount'      => 10000.00,
        ]);

        $account->expenses()->create([
            'category'    => Category::Miscellaneous,
            'description' => 'test expense',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'start'       => '2021-11-01',
            'amount'      => 9000.00,
        ]);

        $account->expenses()->create([
            'category'      => Category::Miscellaneous,
            'description'   => 'test expense',
            'frequency'     => Frequency::Monthly,
            'due_date'      => DueDate::DateInMonth,
            'due_date_meta' => '14th each month',
            'start'         => '2021-11-01',
            'amount'        => 120.00,
        ]);

        $walker = (new ExpensesWalker(
            $this->user,
            Carbon::parse('2022-02-01'),
            Carbon::parse('2022-02-28')
        ))->process();

        $expenses = $walker->graphBalance($account);
        $this->assertEquals(1000, $expenses->get('2022-02-01'));
        $this->assertEquals(1000, $expenses->get('2022-02-06'));
        $this->assertEquals(-500.02, $expenses->get('2022-02-07'));
        $this->assertEquals(-620.02, $expenses->get('2022-02-14'));
        $this->assertEquals(9379.98, $expenses->last());

        $account->checkpoints()->create([
            'registered_date' => '2022-03-07',
            'amount'      => -5000.02,
        ]);

        $walker = (new ExpensesWalker(
            $this->user,
            Carbon::parse('2022-02-01'),
            Carbon::parse('2022-04-31')
        ))->process();

        $expenses = $walker->graphBalanceMonthly($account);
        $this->assertEquals(9379.98, $expenses->get('2022-02'));
        $this->assertEquals(4879.98, $expenses->get('2022-03'));
        $this->assertEquals(5759.98, $expenses->get('2022-04'));
    }

    /** @test */
    public function checkpoints_for_balance_replace_expense()
    {
        /** @var Account $account */
        $account = $this->user->accounts()->create([
            'name'        => 'checkpoint test',
            'description' => 'checkpoint test',
            'balance'     => 10000,
        ]);

        /** @var Expense $expense */
        $expense = $account->expenses()->create([
            'category'    => Category::Utilities,
            'description' => 'Heating and Electricity',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::DateInMonth,
            'due_date_meta' => '7th in month',
            'amount'      => 2500.00,
        ]);

        $expense->checkpoints()->create([
            'registered_date' => '2022-02-09',
            'amount'      => 4000,
        ]);

        $walker = (new ExpensesWalker(
            $this->user,
            Carbon::parse('2022-02-01'),
            Carbon::parse('2022-02-28')
        ))->process();

        $expenses = $walker->graphBalance($account);
        $this->assertEquals(10000, $expenses->get('2022-02-01'));
        $this->assertEquals(10000, $expenses->get('2022-02-07'));
        $this->assertEquals(6000, $expenses->get('2022-02-09'));
        $this->assertEquals(6000, $expenses->get('2022-02-27'));
    }

}
