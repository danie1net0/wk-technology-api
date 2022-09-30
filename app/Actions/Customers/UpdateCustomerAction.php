<?php

namespace App\Actions\Customers;

use App\Models\Customer;

class UpdateCustomerAction
{
    public function execute(Customer $customer, array $params): Customer
    {
        $customer->address()
            ->update($params['address']);

        return tap($customer)->update([
            'name' => $params['name'],
            'cpf' => $params['cpf'],
            'email' => $params['email'],
            'birth_date' => $params['birth_date'],
        ]);
    }
}
