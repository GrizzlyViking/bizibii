<?php

namespace Tests\Feature;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Http\Livewire\AccountForm;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * @property $user
 */
class AccountLiveWireTest extends TestCase
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

        Livewire::test(AccountForm::class)
            ->set('name', $this->faker->word)
            ->set('description', 'test expense')
            ->set('balance', 1000)
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertTrue(true);
    }
}
