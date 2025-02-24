<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{
    public function run()
    {
        // Create some sample cars
        Car::create([
            'name' => 'Honda Civic',
            'brand' => 'Honda',
            'model' => 'Civic',
            'year' => 2020,
            'car_type' => 'Sedan',
            'daily_rent_price' => 50.00,
            'availability' => true,
            'image' => 'honda_civic.jpg',
        ]);

        Car::create([
            'name' => 'Toyota Corolla',
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2021,
            'car_type' => 'Sedan',
            'daily_rent_price' => 60.00,
            'availability' => true,
            'image' => 'toyota_corolla.jpg',
        ]);

        Car::create([
            'name' => 'Ford Mustang',
            'brand' => 'Ford',
            'model' => 'Mustang',
            'year' => 2022,
            'car_type' => 'SUV',
            'daily_rent_price' => 100.00,
            'availability' => false,
            'image' => 'ford_mustang.jpg',
        ]);
    }
}
