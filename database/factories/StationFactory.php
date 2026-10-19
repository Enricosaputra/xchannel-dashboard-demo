<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StationFactory extends Factory
{
    public function definition(): array
    {
        $city = fake()->unique()->city();

        return ['name' => "XChannel $city", 'city' => $city, 'frequency' => '99.9 FM', 'stream_status' => 'live', 'is_active' => true];
    }
}
