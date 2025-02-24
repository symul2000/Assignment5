<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        // Fetch all cars
        $cars = Car::all();

        // Return the view to manage cars
        return view('admin.cars.index', compact('cars'));
    }

    // Show the form to create a new car
    public function create()
    {
        return view('admin.cars.create'); // The view that holds the car creation form
    }

    // Store the new car in the database
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'model' => 'required|string|max:255',
    //         'year' => 'required|integer',
    //         'price' => 'required|numeric',
    //         'description' => 'nullable|string',
    //     ]);

    //     // Create the car entry
    //     Car::create([
    //         'model' => $request->model,
    //         'year' => $request->year,
    //         'price' => $request->price,
    //         'description' => $request->description,
    //     ]);

    //     return redirect()->route('admin.cars.index')->with('success', 'Car added successfully!');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'car_type' => 'required|string',
            'daily_rent_price' => 'required|numeric',
            'availability' => 'required|boolean',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Handle image upload
        $imagePath = $request->file('image')->store('cars', 'public');

        Car::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'car_type' => $request->car_type,
            'daily_rent_price' => $request->daily_rent_price,
            'availability' => $request->availability,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully!');
    }

    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
        ]);
    
        $car->update([
            'name' => $request->name,
            'brand' => $request->brand,
            'model' => $request->model,
        ]);
    
        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully.');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Car deleted successfully!');
    }
}
