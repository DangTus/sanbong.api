<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationStatus extends Model
{
    use HasFactory;

    protected $table = 'location_status';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];
}
