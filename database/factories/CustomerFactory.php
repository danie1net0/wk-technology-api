<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'cpf' => $this->faker->cpf(false),
            'email' => $this->faker->email,
            'birth_date' => $this->faker->date,
        ];
    }
}
