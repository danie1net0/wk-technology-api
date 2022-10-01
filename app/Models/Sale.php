<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $customer_id
 * @property int $quantity
 * @property Carbon created_at
 * @property Customer $customer
 * @property-read Collection<int, Product> $products
 * @property-read float $total
 */
class Sale extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function total(): Attribute
    {
        return Attribute::get(
            fn () => $this->products
                ->map(fn (Product $product) => $product->unit_value * $product->sale->quantity)
                ->sum()
        );
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->as('sale')
            ->withPivot('quantity');
    }
}
