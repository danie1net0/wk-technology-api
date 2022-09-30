<?php

namespace App\Actions\Customers;

use App\Models\Customer;

class CreateCustomerAction
{
    public function execute(array $params): Customer
    {
        /** @var Customer $customer */
        $customer = Customer::query()
            ->create([
                'name' => $params['name'],
                'cpf' => $params['cpf'],
                'email' => $params['email'],
                'birth_date' => $params['birth_date'],
            ]);

        $customer->address()
            ->create($params['address']);

        return $customer;
    }
}
