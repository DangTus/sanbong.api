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

    public function role()
    {
        return $this->hasOne(UserRole::class, 'id', 'role_id');
    }

    public function status()
    {
        return $this->hasOne(UserStatus::class, 'id', 'status_id');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'dob' => $this->dob,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address' => [
                'ward' => $this->ward,
                'description' => $this->address
            ],
            'role' => $this->role,
            'status' => $this->status
        ];
    }
}
