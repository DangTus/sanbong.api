<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    use HasFactory;

    protected $table = 'field_type';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];

    public function prices()
    {
        return $this->hasMany(Price::class, 'fieldtype_id', 'id');
    }
}
