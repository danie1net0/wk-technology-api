<?php

namespace App\Http\Resources;

use App\Models\Sale;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Sale
 */
class SaleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'total' => number_format($this->total, 2),
            'date_time' => $this->created_at->format('Y-m-d H:i:s'),
            'customer' => CustomerResource::make($this->customer),
            'products' => ProductResource::collection($this->products),
        ];
    }
}
