<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'location';

    protected $fillable = ['name', 'description', 'owner_id', 'image', 'time_open', 'time_close', 'ward_id', 'address', 'link_map', 'status_id'];

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function ward()
    {
        return $this->hasOne(Ward::class, 'id', 'ward_id');
    }

    public function status()
    {
        return $this->hasOne(LocationStatus::class, 'id', 'status_id');
    }

    private function getImage()
    {
        $listImage = json_decode($this->image);
        $listImageNew = [];

        foreach ($listImage as $image) {
            $imageNew = app()->make('url')->to('/') . '/public/imgs/location/' . $image;
            array_push($listImageNew, $imageNew);
        }

        return $listImageNew;
    }

    private function getPriceRange()
    {
        $price = Price::where('location_id', $this->id);

        $maxPrice = $price->max('value');
        $minPrice = $price->min('value');

        return [
            'max' => $maxPrice,
            'min' => $minPrice
        ];
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'owner' => $this->owner,
            'image' => $this->getImage(),
            'time_open' => $this->time_open,
            'time_close' => $this->time_close,
            'price' => $this->getPriceRange(),
            'address' => [
                'ward' => $this->ward,
                'description' => $this->address
            ],
            'link_map' => $this->link_map,
            'status' => $this->status
        ];
    }
}
