<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'location';

    protected $fillable = ['name', 'description', 'owner_id', 'image', 'time_open', 'time_close', 'ward_id', 'address', 'status_id'];

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function ward()
    {
        return $this->hasOne(Ward::class, 'id', 'ward_id');
    }

    public function status()
    {
        return $this->hasOne(LocationStatus::class, 'id', 'status_id');
    }

    public function locationFieldTypes()
    {
        return $this->hasMany(LocationFieldType::class, 'location_id', 'id');
    }
}
