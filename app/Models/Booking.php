<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['field_timeslot_id', 'customer_id', 'customer_name', 'phone_number', 'date_book', 'price', 'status_id'];

    public function fieldTimeSlot()
    {
        return $this->hasOne(FieldTimeSlot::class, 'id', 'field_timeslot_id');
    }

    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    public function status()
    {
        return $this->hasOne(BookingStatus::class, 'id', 'status_id');
    }
}
