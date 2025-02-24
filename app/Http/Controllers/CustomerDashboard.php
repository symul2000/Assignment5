<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Rental;
use Carbon\Carbon;

class CustomerDashboard extends Controller
{
    public function index()
    {
        // Fetch available cars for booking
        $availableCars = Car::whereDoesntHave('rentals', function ($query) {
            $query->where('start_date', '<=', Carbon::now())
                  ->where('end_date', '>=', Carbon::now());
        })->get();

        // Fetch the user's rentals
        $rentals = auth()->user()->rentals;

        // Return the customer dashboard view with the available cars and rentals data
        return view('customer.dashboard', compact('availableCars', 'rentals'));
    }

    
}
