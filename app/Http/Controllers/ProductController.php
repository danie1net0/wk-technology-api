<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\{StoreProductRequest, UpdateProductRequest};
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\{Request, Response};

class ProductController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        if ($request->has('without_pagination')) {
            return ProductResource::collection(
                Product::query()->get()
            );
        }

        return ProductResource::collection(
            Product::query()->paginate(7)
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
