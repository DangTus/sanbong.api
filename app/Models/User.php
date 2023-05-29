<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'user';

    protected $fillable = ['name', 'image', 'dob', 'phone_number', 'email', 'password', 'ward_id', 'address', 'role_id', 'status_id'];

    protected $hidden = ['password'];

    public function ward()
    {
        return $this->hasOne(Ward::class, 'id', 'ward_id');
    }

    public function userRole()
    {
        return $this->hasOne(UserRole::class, 'id', 'role_id');
    }

    public function userStatus()
    {
        return $this->hasOne(UserStatus::class, 'id', 'status_id');
    }
}
