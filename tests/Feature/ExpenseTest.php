<?php

namespace Tests\Feature;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\BankAccount;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ExpenseTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    private User $user;
    private BankAccount $account;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::find(1);
        $this->user->bankAccounts()->save(BankAccount::factory()->make());
    }

    /**
     * @test
     *
     * @return void
     */
    public function create_expense(): void
    {
        $expense = new Expense();
        $expense->bank_account_id = $this->user->bankAccounts->first()->id;
        $expense->description = 'create_expense';
        $expense->category = Category::Miscellaneous;
        $expense->amount = $this->faker->randomFloat(2, 10, 1000);
        $expense->start = Carbon::createFromDate(2022, 1, 1);
        $expense->frequency = Frequency::Monthly;
        $expense->due_date = DueDate::DateInMonth;

        $expense->save();

        $this->assertTrue($expense instanceof Expense);
    }

    /**
     * @test
     * @return void
     */
    public function due_date_was_start_of_month()
    {
        $expense = Expense::factory()->make([
            'user_id'   => 1,
            'frequency' => Frequency::Monthly,
            'due_date'  => DueDate::FirstOfMonth,
        ]);

        $date = Carbon::createFromDate(2022, 4, 1);

        $this->assertTrue($expense->applicable($date));
    }

    /**
     * @test
     * @return void
     */
    public function due_date_was_first_workingday_of_month(): void
    {
        $expense = Expense::factory()->make([
            'user_id'   => 1,
            'frequency' => Frequency::Monthly,
            'due_date'  => DueDate::FirstWorkingDayOfMonth,
        ]);

        $date = Carbon::createFromDate(2022, 5, 2);

        $this->assertTrue($expense->applicable($date));
    }

    /**
     * @test
     * @return void
     */
    public function due_date_was_last_of_month()
    {
        $expense = Expense::factory()->make([
            'user_id'   => 1,
            'frequency' => Frequency::Monthly,
            'due_date'  => DueDate::LastDayOfMonth,
        ]);

        $date = Carbon::createFromDate(2022, 4, 30);

        $this->assertTrue($expense->applicable($date));
    }

    /**
     * @test
     * @return void
     */
    public function due_date_was_last_working_day_of_month()
    {
        $expense = Expense::factory()->make([
            'user_id'   => 1,
            'frequency' => Frequency::Monthly,
            'due_date'  => DueDate::LastWorkingDayOfMonth,
        ]);

        $date = Carbon::createFromDate(2022, 4, 29);

        $this->assertTrue($expense->applicable($date));
    }

    /**
     * @test
     * @return void
     */
    public function due_date_was_first_day_year()
    {
        $expense = Expense::factory()->make([
            'user_id'   => 1,
            'frequency' => Frequency::Monthly,
            'due_date'  => DueDate::FirstDayOfYear,
        ]);

        $date = Carbon::createFromDate(2022, 1, 1);

        $this->assertTrue($expense->applicable($date));
    }

    /**
     * @test
     * @return void
     */
    public function due_date_was_day_of_week()
    {
        $expense = Expense::factory()->make([
            'user_id'   => 1,
            'frequency' => Frequency::Monthly,
            'due_date'  => DueDate::Tuesday,
        ]);

        $date = Carbon::createFromDate(2022, 4, 5);

        $this->assertTrue($expense->applicable($date));
    }

    /**
     * @test
     * @return void
     */
    public function is_the_expense_on_date(): void
    {
        $expense = Expense::factory()->make([
            'user_id'       => 1,
            'frequency'     => Frequency::Monthly,
            'due_date'      => DueDate::DateInMonth,
            'due_date_meta' => '17th in month',
        ]);

        $date17 = Carbon::createFromDate(2022, 5, 17);

        $this->assertTrue($expense->applicable($date17));
    }

    /**
     * @test
     * @return void
     */
    public function is_the_expense_on_date_falls_on_weekend(): void
    {
        $expense = Expense::factory()->make([
            'user_id'       => 1,
            'frequency'     => Frequency::Monthly,
            'due_date'      => DueDate::DateInMonth,
            'due_date_meta' => '14th in month',
        ]);

        $date17 = Carbon::createFromDate(2022, 5, 16);

        $this->assertTrue($expense->applicable($date17));
    }

    /** @test */
    public function calculate_expenses_cost()
    {
        $expense = Expense::factory()->make([
            'user_id'  => 1,
            'category' => Category::Financial,
            'amount'   => 123.01,
        ]);

        $this->assertEquals(123.01, $expense->getCost());
    }

    /** @test */
    public function calculate_expenses_income()
    {
        $income = Expense::factory()->make([
            'user_id'  => 1,
            'category' => Category::Income,
            'amount'   => 123.01,
        ]);

        $this->assertEquals(-123.01, $income->getCost());
    }

    /** @test */
    public function calculate_expenses_income_while_correcting_data()
    {
        $income = Expense::factory()->make([
            'user_id'  => 1,
            'category' => Category::Income,
            'amount'   => -123.01,
        ]);

        $this->assertEquals(-123.01, $income->getCost());
    }

    /** @test
     * @throws \Exception
     */
    public function frequency_is_every_three_month()
    {
        $expense = new Expense([
            'category' => Category::House,
            'description' => 'Mortgage',
            'frequency' => Frequency::Every3rdMonth,
            'start' => '2021-04-01',
            'due_date' => DueDate::FirstWorkingDayOfMonth,
            'amount' => 8600.00
        ]);


        $every3Months1 = Carbon::createFromDate(2022, 1, 3);
        $this->assertTrue($expense->applicable($every3Months1),
            $every3Months1->format('Y-m-d') . ' does not fall on ' .
            DueDate::FirstWorkingDayOfMonth->value . ' ' .
            Frequency::Every3rdMonth->value
        );
        $every3Months2 = Carbon::createFromDate(2022, 2, 1);
        $this->assertFalse($expense->applicable($every3Months2),
            $every3Months1->format('Y-m-d') . ' shouldn\'t fall on ' .
            DueDate::FirstWorkingDayOfMonth->value . ' ' .
            Frequency::Every3rdMonth->value
        );
    }

    /** @test */
    public function post_and_validate_expense()
    {
        $response = $this->actingAs($this->user)->post('admin/expenses', [
            'bank_account_id' => $this->user->bankAccounts->first()->id,
            'description'     => 'test expense',
            'category'        => Category::all()->random(1)->first()->value,
            'frequency'       => Frequency::Monthly->value,
            'due_date'        => DueDate::FirstWorkingDayOfMonth->value,
            'amount'          => $this->faker->randomFloat(),
        ]);

        $response->assertOk();
    }

    /** @test */
    public function due_date_is_date_in_month_so_due_date_meta_must_be_set()
    {
        $response = $this->actingAs($this->user)->post('admin/expenses', [
            'bank_account_id' => $this->user->bankAccounts->first()->id,
            'description'     => 'test expense',
            'category'        => Category::all()->random(1)->first()->value,
            'frequency'       => Frequency::Monthly->value,
            'due_date'        => DueDate::FirstOfMonth->value,
            'amount'          => $this->faker->randomFloat(),
        ]);

        $response->assertOk();

        $response = $this->actingAs($this->user)->post('admin/expenses', [
            'bank_account_id' => $this->user->bankAccounts->first()->id,
            'description'     => 'test expense',
            'category'        => Category::all()->random(1)->first()->value,
            'frequency'       => Frequency::Monthly->value,
            'due_date'        => DueDate::DateInMonth->value,
            'amount'          => $this->faker->randomFloat(),
        ]);

        $response->assertInvalid('due_date_meta');
    }

    /** @test */
    public function expenses_must_use_start_and_end_date()
    {
        $expense = Expense::factory()->make([
            'bank_account_id' => $this->user->bankAccounts->first()->id,
            'description'     => 'test expense',
            'category'        => Category::all()->random(1)->first()->value,
            'frequency'       => Frequency::Monthly->value,
            'due_date'        => DueDate::FirstOfMonth->value,
            'amount'          => $this->faker->randomFloat(),
            'start'           => Carbon::createFromDate(2022,05,01),
            'end'             => Carbon::createFromDate(2022,07,01)
        ]);

        $before = Carbon::createFromDate(2022, 4, 1);
        $between = Carbon::createFromDate(2022, 6, 1);
        $after = Carbon::createFromDate(2022, 8, 1);

        $this->assertFalse($expense->applicable($before), 'Start date should be respected.');
        $this->assertTrue($expense->applicable($between), 'Start and end date should be respected start date and end date.');
        $this->assertFalse($expense->applicable($after), 'End date should be respected.');
    }

    /** @test */
    public function end_date_is_null() {
        $expense_end_is_null = Expense::factory()->make([
            'bank_account_id' => $this->user->bankAccounts->first()->id,
            'description'     => 'test expense',
            'category'        => Category::all()->random(1)->first()->value,
            'frequency'       => Frequency::Monthly->value,
            'due_date'        => DueDate::FirstOfMonth->value,
            'amount'          => $this->faker->randomFloat(),
            'start'           => Carbon::createFromDate(2022,05,01),
            'end'             => null
        ]);

        $after = Carbon::createFromDate(2022, 8, 1);

        $this->assertTrue($expense_end_is_null->applicable($after), 'End date was null.');
    }

}
