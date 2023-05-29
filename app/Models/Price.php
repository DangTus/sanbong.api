<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $table = 'price';

    protected $fillable = ['timeslot_id', 'fieldtype_id', 'value'];

    public function timeSlot()
    {
        return $this->hasOne(TimeSlot::class, 'id', 'timeslot_id');
    }

    public function fieldType()
    {
        return $this->hasOne(LocationFieldType::class, 'id', 'fieldtype_id');
    }
}
