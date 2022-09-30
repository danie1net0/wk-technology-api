<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $address_id
 * @property string $name
 * @property string $cpf
 * @property string $email
 * @property Carbon $birth_date
 * @property Address $address
 */
class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
