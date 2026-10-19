<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShowFactory extends Factory
{
    public function definition(): array
    {
        return ['title' => ucfirst(fake()->unique()->words(2, true)), 'is_active' => true];
    }
}
