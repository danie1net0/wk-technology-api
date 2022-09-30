<?php

use App\Actions\Customers\UpdateCustomerAction;
use App\Models\{Address, Customer};
use function Pest\Laravel\assertDatabaseHas;

test('it should update a customer', function () {
    /** @var Customer $customer */
    $customer = Customer::factory()
        ->has(Address::factory())
        ->create();

    $customerAttributes = Customer::factory()
        ->make()
        ->toArray();

    $addressAttributes = Address::factory()
        ->make()
        ->toArray();

    (new UpdateCustomerAction())->execute($customer, [
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
