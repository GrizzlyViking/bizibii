<?php

namespace Tests\Feature;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Http\Livewire\ExpenseForm;
use App\Models\Account;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ExpenseLiveWireTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::find(1);
    }

    /** @test */
    function can_create_expense()
    {
        $this->actingAs($this->user);

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::Miscellaneous->value)
            ->set('expense.frequency', Frequency::Monthly->value)
            ->set('expense.due_date', DueDate::FirstWorkingDayOfMonth->value)
            ->set('expense.amount', $this->faker->randomFloat())
            ->set('start_date', '2022-01-01')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertTrue(Expense::whereDescription('test expense')->exists());
    }

    /** @test */
    function due_date_is_date_in_month_so_due_date_meta_must_be_set()
    {
        $this->actingAs($this->user);

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::Miscellaneous)
            ->set('expense.frequency', Frequency::Monthly)
            ->set('expense.due_date', DueDate::DateInMonth)
            ->set('expense.amount', $this->faker->randomFloat())
            ->set('start_date', '2022-01-01')
            ->call('submit')
            ->assertHasErrors(['expense.due_date_meta' => 'required']);
    }

    /** @test */
    function expenses_start_is_required_if_frequency_is_intervals_longer_than_a_month()
    {
        $this->actingAs($this->user);

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::Miscellaneous)
            ->set('expense.frequency', Frequency::Every3rdMonth)
            ->set('expense.due_date', DueDate::LastDayOfMonth)
            ->set('expense.amount', $this->faker->randomFloat())
            ->call('submit')
            ->assertHasErrors(['start_date' => 'required']);

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::Miscellaneous->value)
            ->set('expense.frequency', Frequency::Monthly->value)
            ->set('expense.due_date', DueDate::LastDayOfMonth->value)
            ->set('expense.amount', $this->faker->randomFloat())
            ->call('submit')
            ->assertHasNoErrors();
    }

    /** @test */
    function is_redirected_to_expenses_list_after_creation()
    {
        $this->actingAs($this->user);

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::Miscellaneous->value)
            ->set('expense.frequency', Frequency::Monthly->value)
            ->set('expense.due_date', DueDate::LastDayOfMonth->value)
            ->set('expense.amount', $this->faker->randomFloat())
            ->call('submit')
            ->assertRedirect('/admin/expenses');
    }

    /** @test */
    function validate_if_category_is_day_to_day_consumption_then_DueDate_must_be_last_day_of_month()
    {
        $this->actingAs($this->user);

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::DayToDayConsumption->value)
            ->set('expense.frequency', Frequency::Monthly->value)
            ->set('expense.due_date', DueDate::LastDayOfMonth->value)
            ->set('expense.amount', $this->faker->randomFloat())
            ->call('submit')
            ->assertHasNoErrors();

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::DayToDayConsumption->value)
            ->set('expense.frequency', Frequency::Weekly->value)
            ->set('expense.due_date', DueDate::LastWorkingDayOfMonth->value)
            ->set('expense.amount', $this->faker->randomFloat())
            ->call('submit')
            ->assertHasErrors(['expense.due_date']);
    }

    /** @test */
    function validate_if_due_date_is_first_day_of_year()
    {
        $this->actingAs($this->user);

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::Utilities)
            ->set('expense.frequency', Frequency::Weekly)
            ->set('expense.due_date', DueDate::FirstDayOfYear)
            ->set('expense.amount', $this->faker->randomFloat())
            ->call('submit')
            ->assertHasErrors(['expense.due_date']);
    }

    /** @test */
    function validate_if_category_is_transfer_then_target_account_must_be_set_and_not_self()
    {
        $accountTo = Account::create([
            'user_id' => $this->user->id,
            'name' => 'transferAccount',
            'description' => 'transfer account',
            'balance' => 0,
        ]);

        $this->actingAs($this->user);

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::Transfer)
            ->set('expense.frequency', Frequency::Monthly)
            ->set('expense.due_date', DueDate::LastDayOfMonth)
            ->set('expense.amount', $this->faker->randomFloat())
            ->call('submit')
            ->assertHasErrors(['expense.transfer_to_account_id' => 'required']);

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.transfer_to_account_id', $this->user->accounts->first()->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::Transfer->value)
            ->set('expense.frequency', Frequency::Monthly->value)
            ->set('expense.due_date', DueDate::LastDayOfMonth->value)
            ->set('expense.amount', $this->faker->randomFloat())
            ->call('submit')
            ->assertHasErrors(['expense.transfer_to_account_id'])
            ->assertSee('The account transferred to must be different from the account transfered from.');

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.transfer_to_account_id', $accountTo->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::Transfer->value)
            ->set('expense.frequency', Frequency::Monthly->value)
            ->set('expense.due_date', DueDate::LastDayOfMonth->value)
            ->set('expense.amount', $this->faker->randomFloat())
            ->call('submit')
            ->assertSee('Transfer to account')
            ->assertHasNoErrors(['expense.transfer_to_account_id']);
    }

    /** @test */
    public function there_must_be_no_errors_transferring_to_different_account()
    {
        $this->actingAs($this->user);

        $accountTo = Account::create([
            'user_id' => $this->user->id,
            'name' => 'transferAccount',
            'description' => 'transfer account',
            'balance' => 0,
        ]);

        Livewire::test(ExpenseForm::class)
            ->set('expense.account_id', $this->user->accounts->first()->id)
            ->set('expense.transfer_to_account_id', $accountTo->id)
            ->set('expense.description', 'test expense')
            ->set('expense.category', Category::Transfer)
            ->set('expense.frequency', Frequency::Monthly)
            ->set('expense.due_date', DueDate::LastDayOfMonth)
            ->set('expense.amount', $this->faker->randomFloat())
            ->call('submit')
            ->assertHasNoErrors(['expense.transfer_to_account_id']);
    }

}
