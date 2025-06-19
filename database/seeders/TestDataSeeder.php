<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Household;
use App\Models\Expense;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(3)->create()->each(function ($user) {
            // Create one household per user
            $household = Household::factory()->create();

            // Attach user to household (many-to-many)
            $user->households()->attach($household->id);

            // Create 10 expenses for that household
            Expense::factory(10)->create([
                'household_id' => $household->id,
            ]);
        });
    }
}
