<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $unit_value
 */
class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function unitValue(): Attribute
    {
        return Attribute::make(
            get: static fn (int $value) => $value / 100,
            set: static fn (int $value) => $value * 100,
        );
    }
}
