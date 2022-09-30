<?php

use App\Actions\Customers\CreateCustomerAction;
use App\Models\{Address, Customer};
use function Pest\Laravel\assertDatabaseHas;

test('it should create a customer', function () {
    $customerAttributes = Customer::factory()
        ->make()
        ->toArray();

    $addressAttributes = Address::factory()
        ->make()
        ->toArray();

    $customer = (new CreateCustomerAction())->execute([
        ...$customerAttributes,
        'address' => $addressAttributes,
    ]);

    assertDatabaseHas(Customer::class, [
        'id' => $customer->id,
        ...$customerAttributes,
    ]);

    assertDatabaseHas(Address::class, [
        'customer_id' => $customer->id,
        ...$addressAttributes,
    ]);
});
