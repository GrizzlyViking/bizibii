<?php

namespace Database\Factories;

use App\Enums\Category;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expenses>
 */
class ExpensesFactory extends Factory
{
    /**
     * livia
     *
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'schedule_id' => Schedule::factory()->create()->id,
            'description' => $this->faker->words(3, true),
            'category' => Category::all()->random(1),
            'amount' => $this->faker->randomFloat(2, 0, 4),
            'applied' => $this->faker->boolean,
            'start' => $this->faker->dateTimeThisDecade,
            'end' => $this->faker->dateTimeThisYear,
        ];
    }
}
