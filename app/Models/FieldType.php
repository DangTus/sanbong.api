<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    use HasFactory;

    protected $table = 'field_type';

    protected $fillable = ['name'];

    public function locationFieldTypes()
    {
        return $this->hasMany(LocationFieldType::class, 'fieldtype_id', 'id');
    }
}