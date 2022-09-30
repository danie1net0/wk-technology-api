<?php

namespace App\Http\Requests\Customers;

use App\Rules\CheckCpfRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UpdateCustomerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', new CheckCpfRule(), $this->unique('cpf')],
            'email' => ['required', 'email', $this->unique('email')],
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

    private function unique(string $column): Unique
    {
        return Rule::unique('customers', $column)->ignore($this->route('customer'));
    }
}
