<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function location()
    {
        return $this->hasMany(Location::class, 'status_id', 'id');
    }
}
