<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $table = 'field';

    protected $fillable = ['name', 'description', 'image', 'type_id', 'location_id', 'status_id'];

    public function type()
    {
        return $this->hasOne(FieldType::class, 'id', 'type_id');
    }

    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function status()
    {
        return $this->hasOne(FieldStatus::class, 'id', 'status_id');
    }

    private function getImage()
    {
        $listImage = json_decode($this->image);
        $listImageNew = [];

        foreach ($listImage as $image) {
            $imageNew = app()->make('url')->to('/') . $image;
            array_push($listImageNew, $imageNew);
        }

        return $listImageNew;
    }

    private function getPriceRange()
    {
        $price = Price::where('fieldtype_id', $this->type_id)->where('location_id', $this->location_id);

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
            'image' => $this->getImage(),
            'type' => $this->type,
            'location' => $this->location,
            'price' => $this->getPriceRange(),
            'status' => $this->status
        ];
    }

    public function toArrayDetail()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->getImage(),
            'type' => $this->type,
            'location' => $this->location,
            'status' => $this->status
        ];
    }
}
