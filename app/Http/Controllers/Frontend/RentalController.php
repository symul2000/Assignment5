<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Mail\RentalCancellation;
use App\Mail\RentalConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

class RentalController extends Controller
{
    // Show available cars to rent
    public function bookCar($id)
    {
        $car = Car::findOrFail($id);
        return view('rentals.book', compact('car'));
    }

    // Car Details
    public function show(Car $car)
    {
        // Get all booked dates for this car
        $bookedDates = Rental::where('car_id', $car->id)
            ->where('end_date', '>=', now()) // Get only future bookings
            ->pluck('start_date', 'end_date') // Retrieve start and end dates
            ->toArray();

        return view('cars.details', compact('car', 'bookedDates'));
    }

    // View user's rental history
    public function rentalHistory()
    {
        $rentals = auth()->user()->rentals; // Get rentals for the logged-in user
        return view('rentals.history', compact('rentals'));
    }


   

    public function store(Request $request)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to login first!');
        }
    
        // Validate the request data
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);
    
        // Check if the car is already booked
        $existingRental = Rental::where('car_id', $request->car_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            })
            ->exists();
    
        if ($existingRental) {
            return redirect()->back()->with('error', 'This car is already booked for the selected dates.');
        }
    
        // Create the rental record
        $rental = Rental::create([
            'user_id' => auth()->id(),  // Use the logged-in user's ID
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => 100, // Replace with actual cost calculation
            'rental_status' => 'Ongoing', // Set rental status as 'Ongoing'
        ]);
    
        // Send email to the user and admin
        Mail::to($rental->user->email)->send(new RentalConfirmation($rental));
        Mail::to('qatarfashion01@gmail.com')->send(new RentalConfirmation($rental));  // Replace with admin email
    
        // Redirect the user with a success message
        return redirect()->route('customer.dashboard')->with('success', 'Car booked successfully! Confirmation email has been sent.');
    }
    


    public function cancel($id)
{
    $rental = Rental::where('id', $id)
        ->where('user_id', auth()->id()) // Ensure the user owns this rental
        ->where('start_date', '>', now()) // Ensure rental hasn't started
        ->first();

    if (!$rental) {
        return redirect()->back()->with('error', 'You cannot cancel this booking.');
    }

    // Update rental status to 'Cancelled'
    $rental->update(['rental_status' => 'Cancelled']);

    // Send cancellation email
    Mail::to($rental->user->email)->send(new RentalCancellation($rental));
    Mail::to('admin@example.com')->send(new RentalCancellation($rental)); // Replace with admin email

    return redirect()->back()->with('success', 'Your booking has been cancelled successfully.');
}
}
