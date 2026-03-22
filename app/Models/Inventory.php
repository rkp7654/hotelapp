<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $fillable = [
        'room_type_id',
        'breakfast_price',
        'available_on',
        'available_rooms',
        'room_number'
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function prices()
    {
        return $this->hasMany(PriceWithPerson::class, 'inventory_id');
    }
}
