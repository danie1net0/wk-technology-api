<?php

use App\Actions\Sales\CreateSaleAction;
use App\Models\{Customer, Product, Sale};
use function Pest\Laravel\assertDatabaseHas;

test('it should create a sale', function () {
    /** @var Customer $customer */
    $customer = Customer::factory()->create();

    $products = Product::factory()
        ->set('unit_value', 1)
        ->count(3)
        ->create()
        ->map(fn (Product $product, int $key) => [
            'id' => $product->id,
            'quantity' => $key + 1,
        ]);

    $sale = (new CreateSaleAction())->execute([
        'customer_id' => $customer->id,
        'products' => $products->toArray(),
    ]);

    expect($sale->total)->toBe(6)
        ->and($sale->products->pluck('id'))->toEqual($products->pluck('id'));

    assertDatabaseHas(Sale::class, [
        'id' => $sale->id,
        'customer_id' => $sale->customer_id,
    ]);
});
