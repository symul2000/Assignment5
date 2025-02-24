<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\User;
use App\Models\Rental;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RentalController extends Controller
{
    // Show all rentals
    public function index()
    {
        $rentals = Rental::all();
        return view('admin.rentals.index', compact('rentals'));
    }

    // Create a rental (Admin managing rentals)
    public function create()
    {
        $users = User::all();
        $cars = Car::all();
        return view('admin.rentals.create', compact('users', 'cars'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Fetch car rental price
        $car = Car::find($request->car_id);
        if (!$car || $car->rental_price_per_day <= 0) {
            return back()->withErrors(['car_id' => 'Car rental price is not set!']);
        }

        // Calculate rental days
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $days = $start_date->diffInDays($end_date) + 1;

        // Calculate total rental cost
        $total_cost = $days * $car->rental_price_per_day;

        // Determine cancellable status
        $cancellable = $start_date->greaterThan(Carbon::now());

        // Create the rental entry
        Rental::create([
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $total_cost,
            'status' => 'Ongoing',
            'cancellable' => $cancellable,
        ]);

        return redirect()->route('admin.rentals.index')->with('success', 'Rental created successfully.');
    }


    // Edit rental (admin changes rental details)
    public function edit($id)
    {
        $rental = Rental::find($id);
        $users = User::all();
        $cars = Car::all();
        return view('admin.rentals.edit', compact('rental', 'users', 'cars'));
    }

    // Update rental status, etc.
    public function update(Request $request, $id)
    {
        $rental = Rental::find($id);
        $rental->update($request->all());
        return redirect()->route('admin.rentals.index');
    }

    // Delete a rental
    public function destroy($id)
    {
        $rental = Rental::find($id);
        $rental->delete();
        return redirect()->route('admin.rentals.index');
    }

    public function cancel(Rental $rental)
    {
        if (!$rental->cancellable) {
            return back()->with('error', 'This rental cannot be cancelled.');
        }

        $rental->update([
            'status' => 'Cancelled',
            'cancellable' => false,  // Mark as no longer cancellable
        ]);

        return redirect()->route('admin.rentals.index')->with('success', 'Rental has been cancelled.');
    }
}
