<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldTimeSlotStatus extends Model
{
    use HasFactory;

    protected $table = 'field_timeslot_status';

    protected $fillable = ['name'];
}
