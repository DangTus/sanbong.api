<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'dob' => $this->dob,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'ward' => WardResource::make($this->ward),
            'address' => $this->address,
            'role' => UserRoleResource::make($this->role),
            'status' => UserStatusResource::make($this->status),
            'created_at' => $this->created_at->format('H:i:s Y-m-d')
        ];
    }
}
