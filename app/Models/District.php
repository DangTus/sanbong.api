<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'district';

    protected $fillable = ['name'];

    protected $hidden = ['province_id', 'created_at', 'updated_at'];

    public function province()
    {
        return $this->hasOne(Province::class, 'id', 'province_id');
    }

    public function wards()
    {
        return $this->hasMany(Ward::class, 'district_id', 'id');
    }
}
