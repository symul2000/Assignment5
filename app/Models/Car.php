<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

     // Define the fillable properties for mass assignment
     protected $fillable = [
        'name',
        'brand',
        'model',
        'year',
        'car_type',
        'image',
        'daily_rent_price',
        'availability',  // Add availability here
    ];

    // Other relationships and methods...
    // Define the rentals relationship
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    // Check if the car is available for rent
    public function isAvailable()
    {
        // Check if the car has any rental with status 'pending' or 'approved'
        $rented = $this->rentals()->whereIn('status', ['pending', 'approved'])->exists();
        return !$rented; // Return true if no rental is found, i.e., the car is available
    }

    public function getGalleryAttribute()
{
    return json_decode($this->attributes['gallery'], true) ?? [];
}
}

