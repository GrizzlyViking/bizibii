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
use Tests\TestCase;

class AccountTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /** @test * */
    public function create_account()
    {
        // Arrange
        $account = new Account();
        $account->user_id = User::find(1)->id;
        $account->name = 'test create account';
        $account->description = 'description';

        // Act
        $account->save();

        // Assert
        $this->assertDatabaseHas('accounts', ['name' => 'test create account']);
    }

    /** @test * */
    public function create_expenses_for_account()
    {
        // Arrange
        /** @var Account $account */
        $account = Account::factory()->create([
            'user_id' => User::find(1)->id,
        ]);

        // Act
        $account->expenses()->saveMany(Expense::factory(5)->make());

        // Assert
        $this->assertDatabaseCount('expenses', 5);
        $this->assertCount(5, $account->expenses);
    }

    /** @test * */
    public function get_incoming_transfers()
    {
        // Arrange
        /** @var Account $accountFrom */
        $accountFrom = Account::factory()->create([
            'user_id' => User::find(1)->id,
            'balance' => 1000,
        ]);
        /** @var Account $accountTo */
        $accountTo = Account::factory()->create([
            'user_id' => User::find(1)->id,
            'balance' => 0,
        ]);

        // Act
        $expense = Expense::create([
            'account_id'             => $accountFrom->id,
            'transfer_to_account_id' => $accountTo->id,
            'description'            => 'test transfer',
            'category'               => Category::Transfer->value,
            'frequency'              => Frequency::Monthly->value,
            'due_date'               => DueDate::FirstOfMonth->value,
            'amount'                 => 1000,
        ]);

        // Assert
        $this->assertDatabaseHas('expenses', ['transfer_to_account_id' => $accountTo->id]);
        $this->assertCount(1, $accountTo->incomingTransfers);
        $this->assertTrue($accountTo->incomingTransfers()->where('description', '=','test transfer')->exists());
    }

    /** @test **/
    public function graph_income()
    {
        // Arrange
        /** @var Account $account */
        $account = User::find(1)->accounts->first();
        $walker = new ExpensesWalker(Carbon::parse('2022-02'), Carbon::parse('2022-02-28'));
        $income = Expense::create([
            'account_id'             => $account->id,
            'description'            => 'test graph income',
            'category'               => Category::Income->value,
            'frequency'              => Frequency::Monthly->value,
            'due_date'               => DueDate::LastDayOfMonth->value,
            'amount'                 => 50000,
        ]);

        // Act
        $month = $account->graphIncomeMonthly($walker);

        // Assert
        $this->assertEquals(50000, $month->last());
    }

}
