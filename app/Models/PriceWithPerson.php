<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceWithPerson extends Model
{
    protected $table = 'price_with_persons';

    protected $fillable = [
        'inventory_id',
        'person_count',
        'price'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
