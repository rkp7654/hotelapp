<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = ['name'];

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'room_type_id');
    }
}
