<?php

namespace Database\Seeders;

use App\Actions\Sales\CreateSaleAction;
use App\Models\{Customer, Product};
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        Collection::times(50, static function () {
            /** @var Customer $customer */
            $customer = Customer::query()
                ->inRandomOrder()
                ->first();

            $products = Product::query()
                ->inRandomOrder()
                ->take(4)
                ->get()
                ->map(fn (Product $product) => [
                    'id' => $product->id,
                    'quantity' => random_int(1, 10),
                ]);

            (new CreateSaleAction())->execute([
                'customer_id' => $customer->id,
                'products' => $products->toArray(),
            ]);
        });
    }
}
