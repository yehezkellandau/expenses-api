<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\User;
use App\Models\Category;
use App\Models\Household;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'household_id' => Household::inRandomOrder()->first()->id, // pick existing household
            'user_id' => User::inRandomOrder()->first()->id,           // pick existing user
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(), // pick existing category
            'name' => $this->faker->sentence(2),
            'amount' => $this->faker->randomFloat(2, 5, 500),
            'method' => $this->faker->randomElement(['cash', 'credit_card']),
            'date' => $this->faker->date(),
        ];
    }
}
