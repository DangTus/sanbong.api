<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
{
    use HasFactory;

    protected $table = 'booking_status';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];
}
