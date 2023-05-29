<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $table = 'field';

    protected $fillable = ['name', 'description', 'image', 'type_id', 'status_id'];

    public function type()
    {
        return $this->hasOne(LocationFieldType::class, 'id', 'type_id');
    }

    public function status()
    {
        return $this->hasOne(FieldStatus::class, 'id', 'status_id');
    }
}
