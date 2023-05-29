<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationFieldType extends Model
{
    use HasFactory;

    protected $table = 'location_fieldtype';

    protected $fillable = ['location_id', 'fieldtype_id'];

    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function fieldType()
    {
        return $this->hasOne(FieldType::class, 'id', 'fieldtype_id');
    }
}
