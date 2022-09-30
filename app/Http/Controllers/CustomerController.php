<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreCustomerRequest, UpdateCustomerRequest};
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CustomerResource::collection(
            Customer::query()->paginate()
        );
    }

    public function store(StoreCustomerRequest $request): CustomerResource
    {
        /** @var Customer $customer */
        $customer = Customer::query()
            ->create($request->only('name', 'cpf', 'email', 'birth_date'));

        $customer
            ->address()
            ->create($request->get('address'));

        return CustomerResource::make($customer->refresh());
    }

    public function show(Customer $customer): CustomerResource
    {
        return CustomerResource::make($customer);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): CustomerResource
    {
        $customer->update($request->only('name', 'cpf', 'email', 'birth_date'));

        $customer->address()->update($request->get('address'));

        return CustomerResource::make($customer);
    }

    public function destroy(Customer $customer): Response
    {
        $customer->delete();

        return response()->noContent();
    }
}
