<?php

use App\Models\{Customer, Product, Sale};
use Illuminate\Support\Collection;

test('it should return paginated product list', function () {
    $sales = Sale::factory()
        ->count(5)
        ->create();

    $this->getJson(route('sales.index'))
        ->assertOk()
        ->assertJsonStructure(['data', 'meta', 'links'])
        ->assertJsonPath('data', saleFormattedData($sales));
});

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

    $saleAttributes = [
        'customer_id' => $customer->id,
        'products' => $products->toArray(),
    ];

    $this->postJson(route('sales.store'), $saleAttributes)
        ->assertCreated();
});

test('it should return a sale by id', function () {
    /** @var Sale $sale */
    $sale = Sale::factory()->create();

    $this->getJson(route('sales.show', $sale->id))
        ->assertOk()
        ->assertJsonPath('data', saleFormattedData($sale));
});

function saleFormattedData(Sale | Collection $sales): array
{
    $formatSale = static fn (Sale $sale) => [
        'id' => $sale->id,
        'total' => number_format($sale->total, 2),
        'date_time' => $sale->created_at->format('Y-m-d H:i:s'),
        'customer' => [
            'id' => $sale->customer->id,
            'name' => $sale->customer->name,
            'cpf' => $sale->customer->cpf,
            'email' => $sale->customer->email,
            'birth_date' => $sale->customer->birth_date,
        ],
        'products' => $sale->products->map(fn (Product $product) => [
            'id' => $product->id,
            'name' => $product->name,
            'unit_value' => number_format($product->unit_value, 2),
            'quantity' => $product->sale->quantity,
        ])->toArray(),
    ];

    if ($sales instanceof Sale) {
        return $formatSale($sales);
    }

    return $sales
        ->map(fn (Sale $sale) => $formatSale($sale))
        ->toArray();
}
