<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'unit_value' => number_format($this->unit_value, 2),
            'quantity' => $this->when(! is_null($this->sale), $this->sale?->quantity),
        ];
    }
}
