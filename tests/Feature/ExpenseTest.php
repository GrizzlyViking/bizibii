<?php

namespace Tests\Feature;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Reality;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ExpenseTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    private User $user;

    private Account $account;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::find(1);
        $this->user->accounts()->save(Account::factory()->make());
    }

    /**
     * @test
     *
     * @return void
     */
    public function create_expense(): void
    {
        $expense = new Expense();
        $expense->account_id = $this->user->accounts->first()->id;
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
        $expense = Expense::create([
            'account_id'  => $this->user->accounts->first()->id,
            'description' => 'test',
            'amount'      => 3.22,
            'category'    => Category::Utilities,
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstOfMonth,
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
        $expense = Expense::create([
            'account_id'  => $this->user->accounts->first()->id,
            'description' => $this->faker->words(1, true),
            'amount'      => $this->faker->randomFloat(2, 0, 4),
            'category'    => Category::Utilities,
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
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
        $expense = Expense::create([
            'account_id'  => $this->user->accounts->first()->id,
            'description' => $this->faker->words(1, true),
            'amount'      => $this->faker->randomFloat(2, 0, 4),
            'category'    => Category::Utilities,
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::LastDayOfMonth,
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
        $expense = Expense::create([
            'account_id'  => $this->user->accounts->first()->id,
            'description' => $this->faker->words(1, true),
            'amount'      => $this->faker->randomFloat(2, 0, 4),
            'category'    => Category::Utilities,
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::LastWorkingDayOfMonth,
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
        $expense = Expense::create([
            'account_id'  => $this->user->accounts->first()->id,
            'description' => $this->faker->words(1, true),
            'amount'      => $this->faker->randomFloat(2, 0, 4),
            'category'    => Category::Utilities,
            'frequency'   => Frequency::Yearly,
            'due_date'    => DueDate::FirstDayOfYear,
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
        $expense = Expense::create([
            'account_id'  => $this->user->accounts->first()->id,
            'description' => $this->faker->words(1, true),
            'amount'      => $this->faker->randomFloat(2, 0, 4),
            'category'    => Category::Utilities,
            'frequency'   => Frequency::Weekly,
            'due_date'    => DueDate::Tuesday,
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
        $expense = Expense::create([
            'account_id'    => $this->user->accounts->first()->id,
            'description'   => $this->faker->words(1, true),
            'amount'        => $this->faker->randomFloat(2, 0, 4),
            'category'      => Category::Utilities,
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
        $expense = Expense::create([
            'account_id'    => $this->user->accounts->first()->id,
            'description'   => $this->faker->words(1, true),
            'amount'        => $this->faker->randomFloat(2, 0, 4),
            'category'      => Category::Utilities,
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
        $expense = Expense::create([
            'account_id'  => $this->user->accounts->first()->id,
            'description' => $this->faker->words(1, true),
            'amount'      => 123.01,
            'category'    => Category::Financial,
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::LastWorkingDayOfMonth,
        ]);

        $this->assertEquals(-123, $expense->getCost());
    }

    /** @test */
    public function calculate_expenses_income()
    {
        $income = Expense::factory()->make([
            'account_id' => $this->user->accounts->first()->id,
            'category'   => Category::Income,
            'amount'     => 123.01,
        ]);

        $this->assertEquals(123, $income->getCost());
    }

    /** @test */
    public function calculate_expenses_income_while_correcting_data()
    {
        $income = Expense::factory()->make([
            'account_id' => $this->user->accounts->first()->id,
            'category'   => Category::Income,
            'amount'     => -123.01,
        ]);

        $this->assertEquals(123, $income->getCost());
    }

    /** @test
     * @throws \Exception
     */
    public function frequency_is_every_three_month()
    {
        $expense = new Expense([
            'category'    => Category::House,
            'description' => 'Mortgage',
            'frequency'   => Frequency::Every3rdMonth,
            'start'       => '2021-04-01',
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 8600.00,
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
    public function expenses_must_use_start_and_end_date()
    {
        $expense = Expense::factory()->make([
            'account_id'  => $this->user->accounts->first()->id,
            'description' => 'test expense',
            'category'    => Category::all()->random(1)->first()->value,
            'frequency'   => Frequency::Monthly->value,
            'due_date'    => DueDate::FirstOfMonth->value,
            'amount'      => $this->faker->randomFloat(),
            'start'       => Carbon::createFromDate(2022, 05, 01),
            'end'         => Carbon::createFromDate(2022, 07, 01),
        ]);

        $before = Carbon::createFromDate(2022, 4, 1);
        $between = Carbon::createFromDate(2022, 6, 1);
        $after = Carbon::createFromDate(2022, 8, 1);

        $this->assertFalse($expense->applicable($before), 'Start date should be respected.');
        $this->assertTrue($expense->applicable($between), 'Start and end date should be respected start date and end date.');
        $this->assertFalse($expense->applicable($after), 'End date should be respected.');
    }

    /** @test */
    public function end_date_is_null()
    {
        $expense_end_is_null = Expense::factory()->make([
            'account_id'  => $this->user->accounts->first()->id,
            'description' => 'test expense',
            'category'    => Category::all()->random(1)->first()->value,
            'frequency'   => Frequency::Monthly->value,
            'due_date'    => DueDate::FirstOfMonth->value,
            'amount'      => $this->faker->randomFloat(),
            'start'       => Carbon::createFromDate(2022, 05, 01),
            'end'         => null,
        ]);

        $after = Carbon::createFromDate(2022, 8, 1);

        $this->assertTrue($expense_end_is_null->applicable($after), 'End date was null.');
    }

    /** @test */
    public function start_date_is_null()
    {
        $expense_start_is_null = Expense::factory()->make([
            'account_id'  => $this->user->accounts->first()->id,
            'description' => 'test expense',
            'category'    => Category::all()->random(1)->first()->value,
            'frequency'   => Frequency::Monthly->value,
            'due_date'    => DueDate::FirstOfMonth->value,
            'amount'      => $this->faker->randomFloat(),
            'start'       => null,
            'end'         => null,
        ]);

        $after = Carbon::createFromDate(2022, 8, 1);

        $this->assertTrue($expense_start_is_null->applicable($after), 'End date was null.');
    }

    /** @test */
    public function add_a_checkpoint_for_expense()
    {
        $expense = Expense::create([
            'account_id'    => $this->user->accounts->first()->id,
            'description'   => $this->faker->words(1, true),
            'amount'        => $this->faker->randomFloat(2, 0, 4),
            'category'      => Category::Utilities,
            'frequency'     => Frequency::Monthly,
            'due_date'      => DueDate::DateInMonth,
            'due_date_meta' => '14th in month',
        ]);

        $expense->checkpoints()->create([
            'amount'          => 10.01,
            'registered_date' => '2022-07-10',
        ]);

        $this->assertTrue(Reality::where('checkpointable_id', $expense->id)->where('checkpointable_type', Expense::class)->exists());

        $expense->checkpoints()->create([
            'amount'          => 30.01,
            'registered_date' => '2022-07-10',
        ]);

        $this->assertCount(2, $expense->checkpoints);

        $this->assertInstanceOf(Carbon::class, $expense->checkpoints->first()->registered_date);
    }

    public function test_checkpoints_replace_expense()
    {
        $expense = Expense::create([
            'account_id'    => $this->user->accounts->first()->id,
            'description'   => $this->faker->words(1, true),
            'amount'        => 2400.00,
            'category'      => Category::Utilities,
            'frequency'     => Frequency::Monthly,
            'due_date'      => DueDate::DateInMonth,
            'due_date_meta' => '14th in month',
        ]);

        $expense->checkpoints()->create([
            'amount'          => 5000.00,
            'registered_date' => '2022-07-10',
        ]);

        $this->assertTrue($expense->applicable(Carbon::parse('2022-07-10')), 'the date on the checkpoint should be used rather than the expenses.');
        $this->assertFalse($expense->applicable(Carbon::parse('2022-07-14')), 'the date on the expense should no longer be used.');
        $this->assertEquals(-5000, $expense->setDateToCheck('2022-07-10')->getCost());
    }

    /** @test **/
    public function frequency_is_daily_and_checkpoint_is_same_date()
    {
        // Arrange
        $expense = Expense::create([
            'account_id'    => $this->user->accounts->first()->id,
            'description'   => $this->faker->words(1, true),
            'amount'        => 200.00,
            'category'      => Category::Utilities,
            'frequency'     => Frequency::Daily,
            'due_date'      => DueDate::Daily,
        ]);

        $expense->checkpoints()->create([
            'amount'          => 500.00,
            'registered_date' => '2022-07-10',
        ]);

        // Assert
        $this->assertTrue($expense->applicable(Carbon::parse('2022-07-10')), 'the date on the checkpoint should be used rather than the expenses.');
        $this->assertEquals(-200, $expense->setDateToCheck(Carbon::parse('2022-07-09'))->getCost());
        $this->assertEquals(-500, $expense->setDateToCheck(Carbon::parse('2022-07-10'))->getCost());
        $this->assertEquals(-200, $expense->setDateToCheck(Carbon::parse('2022-07-11'))->getCost());

    }
}
