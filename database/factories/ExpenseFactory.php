<?php

namespace Database\Factories;

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
    public function definition(): array
    {
        return [
            'category' => fake()->randomElement(['Groceries', 'Rent', 'Bills', 'Transport']),
            'amount' => fake()->randomFloat(2, 10, 500),
            'type' => fake()->randomElement(['cash', 'credit_card']),
            'date' => fake()->dateTimeBetween('-3 months', 'now'),
            'household_id' => null, // will be set in the seeder
        ];
    }
}
