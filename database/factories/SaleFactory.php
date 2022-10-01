<?php

namespace Database\Factories;

use App\Models\{Customer, Product, Sale};
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
        ];
    }

    public function configure(): SaleFactory
    {
        return $this->afterCreating(static function (Sale $sale) {
            Product::factory()
                ->count(4)
                ->create()
                ->each(fn (Product $product) => $sale->products()->attach([
                    $product->id => ['quantity' => 1],
                ]));
        });
    }
}
