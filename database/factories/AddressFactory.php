<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'zip_code' => str_replace('-', '', $this->faker->postcode),
            'public_place' => $this->faker->streetName,
            'number' => $this->faker->buildingNumber,
            'neighborhood' => $this->faker->colorName,
            'city' => $this->faker->city,
        ];
    }
}
