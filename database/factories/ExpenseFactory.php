<?php

namespace Database\Factories;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * livia
     *
     * Define the model's default state.
     *
     * @return array<string, Category, Frequency, float>
     */
    public function definition(): array
    {
        return [
            'account_id' => BankAccount::factory()->create()->id,
            'description' => $this->faker->words(3, true),
            'category' => Category::all()->random(1)->first(),
            'frequency' => Frequency::all()->random(1)->first(),
            'amount' => $this->faker->randomFloat(2, 0, 4),
            'due_date' => ($dueDate = DueDate::all()->random(1)->first()),
            'due_date_meta' => $dueDate->equals(DueDate::DateInMonth) ? '5th of month' : '',
            'applied' => $this->faker->boolean,
            'start' => $this->faker->dateTimeThisDecade,
            'end' => $this->faker->dateTimeThisYear,
        ];
    }
}
