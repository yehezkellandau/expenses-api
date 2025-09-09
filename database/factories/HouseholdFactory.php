<?php

namespace Database\Factories;

use App\Models\Household;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class HouseholdFactory extends Factory
{
    protected $model = Household::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->lastName . ' Family',
            'join_code' => Str::uuid(),
        ];
    }
}
