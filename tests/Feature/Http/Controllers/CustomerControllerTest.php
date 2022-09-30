<?php

use App\Models\{Address, Customer};
use Illuminate\Support\Collection;
use function Pest\Laravel\assertModelMissing;

test('it should return paginated customer list', function () {
    $customers = Customer::factory()
        ->count(5)
        ->has(Address::factory())
        ->create();

    $this->getJson(route('customers.index'))
        ->assertOk()
        ->assertJsonStructure(['data', 'meta', 'links'])
        ->assertJsonPath('data', customerFormattedData($customers));
});

test('it should create a customer', function () {
    $customerAttributes = Customer::factory()
        ->make()
        ->toArray();

    $addressAttributes = Address::factory()
        ->make()
        ->toArray();

    $attributes = [
        ...$customerAttributes,
        'address' => $addressAttributes,
    ];

    $this->postJson(route('customers.store'), $attributes)->assertCreated();
});

test('it should return a customer by id', function () {
    /** @var Customer $customer */
    $customer = Customer::factory()
        ->has(Address::factory())
        ->create();

    $this->getJson(route('customers.show', $customer->id))
        ->assertOk()
        ->assertJsonPath('data', customerFormattedData($customer));
});

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

    $attributes = [
        ...$customerAttributes,
        'address' => $addressAttributes,
    ];

    $this->putJson(route('customers.update', $customer->id), $attributes)
        ->assertOk()
        ->assertJsonPath('data', [
            'id' => $customer->id,
            ...$customerAttributes,
            'address' => $addressAttributes,
        ]);
});

test('it should delete a customer', function () {
    /** @var Customer $customer */
    $customer = Customer::factory()
        ->has(Address::factory())
        ->create();

    $this->deleteJson(route('customers.destroy', $customer->id))
        ->assertNoContent();

    assertModelMissing($customer);
});

function customerFormattedData(Customer | Collection $customers): array
{
    $formatCustomer = static fn (Customer $customer) => [
        'id' => $customer->id,
        'name' => $customer->name,
        'cpf' => $customer->cpf,
        'email' => $customer->email,
        'birth_date' => $customer->birth_date,
        'address' => [
            'zip_code' => $customer->address->zip_code,
            'public_place' => $customer->address->public_place,
            'number' => $customer->address->number,
            'neighborhood' => $customer->address->neighborhood,
            'city' => $customer->address->city,
        ],
    ];

    if ($customers instanceof Customer) {
        return $formatCustomer($customers);
    }

    return $customers
        ->map(fn (Customer $customer) => $formatCustomer($customer))
        ->toArray();
}
