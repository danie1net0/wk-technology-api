<?php

namespace App\Http\Controllers;

use App\Actions\Sales\CreateSaleAction;
use App\Http\Requests\Sales\StoreSaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SaleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return SaleResource::collection(
            Sale::query()->paginate(7)
        );
    }

    public function store(StoreSaleRequest $request, CreateSaleAction $action): SaleResource
    {
        return SaleResource::make(
            $action->execute($request->validated())
        );
    }

    public function show(Sale $sale): SaleResource
    {
        return SaleResource::make($sale);
    }
}
