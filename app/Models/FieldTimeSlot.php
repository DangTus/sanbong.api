<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldTimeSlot extends Model
{
    use HasFactory;

    protected $fillable = ['field_id', 'price_id', 'status_id'];

    public function price()
    {
        return $this->hasOne(Price::class, 'id', 'price_id');
    }

    public function field()
    {
        return $this->hasOne(Field::class, 'id', 'field_id');
    }

    public function status()
    {
        return $this->hasOne(FieldTimeSlotStatus::class, 'id', 'status_id');
    }
}
