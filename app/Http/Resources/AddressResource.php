<?php

namespace App\Http\Resources;

use App\Models\Address;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Address
 */
class AddressResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'zip_code' => $this->zip_code,
            'public_place' => $this->public_place,
            'number' => $this->number,
            'neighborhood' => $this->neighborhood,
            'complement' => $this->when($this->complement, $this->complement),
            'city' => $this->city,
        ];
    }
}
