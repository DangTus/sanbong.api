<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TimeSlot extends Model
{
    use HasFactory;

    protected $table = 'time_slot';

    protected $fillable = ['time_start', 'time_end'];

    protected $hidden = ['created_at', 'updated_at'];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'time_start' => Carbon::createFromFormat('H:i:s', $this->time_start)->format('H:i'),
            'time_end' => Carbon::createFromFormat('H:i:s', $this->time_end)->format('H:i'),
        ];
    }

    public function getWithPrice($location_id, $fieldtype_id)
    {
        $price = Price::where('location_id', $location_id)
            ->where('fieldtype_id', $fieldtype_id)
            ->where('timeslot_id', $this->id)
            ->first();

        $price = $price ? $price->value : null;

        return [
            'id' => $this->id,
            'time_start' => Carbon::createFromFormat('H:i:s', $this->time_start)->format('H:i'),
            'time_end' => Carbon::createFromFormat('H:i:s', $this->time_end)->format('H:i'),
            'price' => $price
        ];
    }
}
