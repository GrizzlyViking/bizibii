<?php

namespace Tests\Feature;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\BankAccount;
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
        $this->user->bankAccounts()->save(BankAccount::factory()->make([
            'balance' => 0,
        ]));
    }

    /** @test */
    public function walk_through_one_week_with_one_expense()
    {
        $this->assertCount(1, $this->user->bankAccounts,
            'the prerequisite user with Account is set up incorrectly');

        /** @var BankAccount $account */
        $account = $this->user->bankAccounts->first();

        $account->expenses()->create([
            'category' => Category::House,
            'description' => 'Mortgage',
            'frequency' => Frequency::Monthly,
            'due_date' => DueDate::FirstWorkingDayOfMonth,
            'amount' => 5800.00
        ]);

        $walker = new ExpensesWalker($this->user, Carbon::createFromDate(2022, 1,1), Carbon::createFromDate(2022, 2,1), 0);

        $complete = $walker->process();

        $this->assertTrue( is_array($complete));
        $this->assertEquals(0.0, $complete['data']->get('2022-01-02')['balance']);
        $this->assertEquals(-5800.0, $complete['data']->get('2022-01-03')['balance']);
        $this->assertInstanceOf(Expense::class, $complete['data']->get('2022-01-03')['expenses']->first());
    }

    /** @test */
    public function walk_through_one_year_with_expenses_and_income()
    {
        $this->assertCount(1, $this->user->bankAccounts,
            'the prerequisite user with Account is set up incorrectly');

        /** @var BankAccount $account */
        $account = $this->user->bankAccounts->first();

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

        $walker = new ExpensesWalker($this->user, Carbon::createFromDate(2022, 1,1), Carbon::createFromDate(2023, 1,1), 0);
        $walker->process();
        $complete = $walker->getGraph();

        $this->assertTrue($complete instanceof Collection);

        $this->assertEquals(-700.0, $complete->get('2022-01-02')['balance']);
        $this->assertEquals(-9450.0, $complete->get('2022-01-03')['balance']);
        $this->assertInstanceOf(Expense::class, $walker->getData()->get('2022-01-03')['expenses']->first());
        $this->assertEquals(140296, $walker->getGraph()->last()['balance']);
    }

}
