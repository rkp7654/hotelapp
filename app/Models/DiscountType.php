<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountType extends Model
{
    protected $table = 'discount_type';

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }
}
