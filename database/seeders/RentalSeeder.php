<?php

namespace Database\Seeders;

use App\Models\Rental;
use App\Models\User;
use App\Models\Car;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RentalSeeder extends Seeder
{
    public function run()
    {
        // Sample data for seeding
        Rental::create([
            'user_id' => User::first()->id, // Assuming there's a user
            'car_id' => Car::first()->id, // Assuming there's a car
            'start_date' => Carbon::now()->addDays(1), // Rental starts tomorrow
            'end_date' => Carbon::now()->addDays(7), // Rental ends in 7 days
            'total_cost' => 500, // Example cost
        ]);
    }
}
