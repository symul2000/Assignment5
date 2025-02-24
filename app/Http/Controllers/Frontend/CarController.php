<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Mail\RentalConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

class CarController extends Controller
{
   

    public function index()
    {
        $cars = Car::with(['rentals' => function ($query) {
            $query->where('end_date', '>=', now());
        }])->get();
    
        return view('cars.index', compact('cars'));
    }

    public function show($id)
    {
        $car = Car::with('rentals')->findOrFail($id);
    
        // Collect all booked date ranges
        $bookedDates = $car->rentals->map(function ($rental) {
            return [
                'start_date' => $rental->start_date,
                'end_date' => $rental->end_date,
            ];
        });
    
        return view('cars.details', compact('car', 'bookedDates'));
    }
    
    
    public function bookCar(Request $request, Car $car)
    {
        // Validate the form data
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    
        // Check if the car is already booked for the selected dates
        $existingRental = Rental::where('car_id', $car->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            })
            ->exists();
    
        if ($existingRental) {
            return redirect()->route('car.details', $car->id)->with('error', 'This car is already booked for the selected dates.');
        }
    
        // Calculate the total cost based on the rental duration
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDays = $startDate->diffInDays($endDate);
        $totalCost = $totalDays * $car->daily_rent_price;
    
        // Create the rental record
        $rental = Rental::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $totalCost,
            'status' => 'pending',  // You can adjust the status based on your logic
        ]);
    
        // Send email to the customer (user)
        Mail::to(auth()->user()->email)->send(new RentalConfirmation($rental));
    
        // Send email to admin
        Mail::to('admin@example.com')->send(new RentalConfirmation($rental));
    
        // Redirect to the customer's dashboard or a success page
        return redirect()->route('customer.dashboard')->with('success', 'Your rental has been successfully booked. Check your email for booking details.');
    }



    
}
