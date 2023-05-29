<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldStatus extends Model
{
    use HasFactory;

    protected $table = 'field_status';

    protected $fillable = ['name'];
}
