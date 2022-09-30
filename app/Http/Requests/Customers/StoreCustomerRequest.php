<?php

namespace App\Http\Requests\Customers;

use App\Rules\CheckCpfRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'unique:customers', new CheckCpfRule()],
            'email' => ['required', 'email', 'unique:customers'],
            'birth_date' => ['required', 'date_format:Y-m-d'],
            'address' => ['required_array_keys:zip_code,public_place,number,neighborhood,city'],
            'address.zip_code' => ['required', 'string', 'size:8'],
            'address.public_place' => ['required', 'string', 'max:255'],
            'address.number' => ['required', 'string', 'max:15'],
            'address.neighborhood' => ['required', 'string', 'max:255'],
            'address.complement' => ['nullable', 'string', 'max:255'],
            'address.city' => ['required', 'string', 'max:255'],
        ];
    }
}
