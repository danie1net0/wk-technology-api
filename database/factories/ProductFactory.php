<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->colorName,
            'unit_value' => $this->faker->randomFloat(2, 1, 6),
        ];
    }
}
