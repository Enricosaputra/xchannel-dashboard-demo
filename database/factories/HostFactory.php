<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HostFactory extends Factory
{
    public function definition(): array
    {
        return ['name' => fake()->unique()->firstName(), 'is_active' => true];
    }
}
