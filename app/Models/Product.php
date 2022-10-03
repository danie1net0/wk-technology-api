<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property int $unit_value
 * @property Sale $sale
 */
class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function unitValue(): Attribute
    {
        return Attribute::make(
            get: static fn (int | float $value) => $value / 100,
            set: static fn (int | float $value) => $value * 100,
        );
    }

    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class)
            ->as('sale')
            ->withPivot('quantity');
    }
}
