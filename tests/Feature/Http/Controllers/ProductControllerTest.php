<?php

use App\Models\Product;
use function Pest\Laravel\{assertDatabaseHas, assertModelMissing};

test('it should return paginated product list', function () {
    $products = Product::factory()
        ->count(5)
        ->create();

    $products = $products->map(fn (Product $product) => [
        'id' => $product->id,
        'name' => $product->name,
        'unit_value' => number_format($product->unit_value, 2),
    ]);

    $this->getJson(route('products.index'))
        ->assertOk()
        ->assertJsonStructure(['data', 'meta', 'links'])
        ->assertJsonPath('data', $products->toArray());
});

test('it should create a product', function () {
    $productAttributes = Product::factory()
        ->make()
        ->toArray();

    $this->postJson(route('products.store'), $productAttributes)
        ->assertCreated();

    assertDatabaseHas(Product::class, [
        'name' => $productAttributes['name'],
        'unit_value' => $productAttributes['unit_value'] * 100,
    ]);
});

test('it should return a product by id', function () {
    /** @var Product $product */
    $product = Product::factory()->create();

    $this->getJson(route('products.show', $product->id))
        ->assertOk()
        ->assertJsonPath('data', [
            'id' => $product->id,
            'name' => $product->name,
            'unit_value' => number_format($product->unit_value, 2),
        ]);
});

test('it should update a product', function () {
    /** @var Product $product */
    $product = Product::factory()->create();

    $productAttributes = Product::factory()
        ->make()
        ->toArray();

    $this->putJson(route('products.update', $product->id), $productAttributes)
        ->assertOk()
        ->assertJsonPath('data', [
            'id' => $product->id,
            'name' => $productAttributes['name'],
            'unit_value' => number_format($productAttributes['unit_value'], 2),
        ]);
});

test('it should delete a product', function () {
    /** @var Product $product */
    $product = Product::factory()->create();

    $this->deleteJson(route('products.destroy', $product->id))
        ->assertNoContent();

    assertModelMissing($product);
});
