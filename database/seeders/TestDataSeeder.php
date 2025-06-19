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
        // Create 4 users
        $users = User::factory(4)->create();

        // Create 2 households
        $household1 = Household::factory()->create();
        $household2 = Household::factory()->create();

        // Assign Users 1 & 2 to Household 1
        $users[0]->households()->attach($household1->id);
        $users[1]->households()->attach($household1->id);

        // Assign Users 3 & 4 to Household 2
        $users[2]->households()->attach($household2->id);
        $users[3]->households()->attach($household2->id);

        // Create 100 expenses for each household
        Expense::factory(100)->create(['household_id' => $household1->id]);
        Expense::factory(100)->create(['household_id' => $household2->id]);
    }
}
