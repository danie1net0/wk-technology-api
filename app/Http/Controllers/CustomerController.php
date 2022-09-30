<?php

namespace App\Http\Controllers;

use App\Actions\Customers\{CreateCustomerAction, UpdateCustomerAction};
use App\Http\Requests\Customers\{StoreCustomerRequest, UpdateCustomerRequest};
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

    public function store(StoreCustomerRequest $request, CreateCustomerAction $action): CustomerResource
    {
        return CustomerResource::make(
            $action->execute($request->validated())
        );
    }

    public function show(Customer $customer): CustomerResource
    {
        return CustomerResource::make($customer);
    }

    public function update(
        UpdateCustomerRequest $request,
        Customer $customer,
        UpdateCustomerAction $action
    ): CustomerResource {
        return CustomerResource::make(
            $action->execute($customer, $request->validated())
        );
    }

    public function destroy(Customer $customer): Response
    {
        $customer->delete();

        return response()->noContent();
    }
}
