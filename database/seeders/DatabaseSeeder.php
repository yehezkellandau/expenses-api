<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Household;
use App\Models\User;
use App\Models\Category;
use App\Models\Expense;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create some fixed categories
        $fixedCategories = [
            'Food',
            'Rent',
            'Utilities',
            'Transportation',
            'Entertainment',
            'Healthcare',
        ];

        foreach ($fixedCategories as $catName) {
            Category::firstOrCreate(['name' => $catName]);
        }

        // 2. Create households with users
        $households = Household::factory()
            ->count(3) // 3 households
            ->has(User::factory()->count(3)) // each with 3 users
            ->create();

        // 3. Get all categories, users, households
        $categories = Category::all();
        $users = User::all();
        $households = Household::all();

        // 4. Create expenses, linking them to random existing household/user/category
        Expense::factory(50)->make()->each(function ($expense) use ($categories, $users, $households) {
            $expense->category_id = $categories->random()->id;
            $expense->user_id = $users->random()->id;
            $expense->household_id = $households->random()->id;
            $expense->save();
        });
    }
}
