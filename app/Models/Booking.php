<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $fillable = ['timeslot_id', 'field_id', 'customer_id', 'customer_name', 'phone_number', 'date_book', 'price', 'note', 'log', 'status_id'];

    protected $hidden = ['updated_at'];

    public function timeSlot()
    {
        return $this->hasOne(TimeSlot::class, 'id', 'timeslot_id');
    }

    public function field()
    {
        return $this->hasOne(Field::class, 'id', 'field_id');
    }

    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    public function status()
    {
        return $this->hasOne(BookingStatus::class, 'id', 'status_id');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'timeSlot' => $this->timeSlot,
            'field' => $this->field,
            'customer' => $this->customer,
            'customer_name' => $this->customer_name,
            'phone_number' => $this->phone_number,
            'date_book' => $this->date_book,
            'price' => $this->price,
            'note' => $this->note,
            'log' => $this->log,
            'status' => $this->status,
        ];
    }
}
