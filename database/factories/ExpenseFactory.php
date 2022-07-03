<?php

namespace Database\Factories;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory()->create()->id,
            'description' => $this->faker->words(1, true),
            'category' => Category::Miscellaneous,
            'frequency' => Frequency::Monthly,
            'amount' => $this->faker->randomFloat(2, 0, 4),
            'due_date' => DueDate::FirstWorkingDayOfMonth,
        ];
    }
}
