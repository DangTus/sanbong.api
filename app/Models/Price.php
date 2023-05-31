<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $table = 'price';

    protected $fillable = ['timeslot_id', 'fieldtype_id', 'location_id', 'value'];

    public function timeSlot()
    {
        return $this->hasOne(TimeSlot::class, 'id', 'timeslot_id');
    }

    public function fieldType()
    {
        return $this->hasOne(FieldType::class, 'id', 'fieldtype_id');
    }

    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function getStatus($fieldID, $dateBook)
    {
        $isBooking = Booking::where('timeslot_id', $this->timeslot_id)
            ->where('field_id', $fieldID)
            ->where('date_book', $dateBook)
            ->whereIn('status_id', [1, 2])
            ->get();
        $status = $isBooking->count() ? 'not-ready' : 'ready';

        return [
            'id' => $this->id,
            'timeSlot' => $this->timeSlot,
            'value' => $this->value,
            'status' => $status
        ];
    }
}
