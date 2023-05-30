<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'province';

    protected $fillable = ['name'];

    protected $hidden = ['priority', 'created_at', 'updated_at'];

    public function districts()
    {
        return $this->hasMany(District::class, 'province_id', 'id');
    }
}
