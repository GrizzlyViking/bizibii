<?php

namespace Database\Factories;

use App\Enums\Category;
use App\Models\Tag;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    public function configure() {
        return $this->afterCreating(function (Transaction $transaction) {
            $transaction->tags()->attach(Tag::all()->random(3));
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(2, -2000, 2000),
            'description' => $this->faker->words(3, true),
            'category' => Category::all()->random(1)->first(),
        ];
    }
}
