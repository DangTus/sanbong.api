<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $table = 'field';

    protected $fillable = ['name', 'description', 'type_id', 'location_id', 'status_id'];

    public function type()
    {
        return $this->hasOne(FieldType::class, 'id', 'type_id');
    }

    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function status()
    {
        return $this->hasOne(FieldStatus::class, 'id', 'status_id');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'location' => $this->location,
            'status' => $this->status
        ];
    }
}
