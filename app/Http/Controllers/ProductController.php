<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\{StoreProductRequest, UpdateProductRequest};
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(
            Product::query()->paginate()
        );
    }

    public function store(StoreProductRequest $request): ProductResource
    {
        return ProductResource::make(
            Product::query()->create($request->validated())
        );
    }

    public function show(Product $product): ProductResource
    {
        return ProductResource::make($product);
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        return ProductResource::make(
            tap($product)->update($request->validated())
        );
    }

    public function destroy(Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
