<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Rental;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail; // For email notifications

class PageController extends Controller
{
    public function index()
    {
        // Fetch all cars with their rentals
        $cars = Car::with(['rentals' => function ($query) {
            $query->where('end_date', '>=', now());
        }])->get();
    
        return view('welcome', compact('cars'));
    }
    

    public function show(Car $car)
    {
        if (!auth()->check()) {
            return redirect()->route('register')->with('error', 'Please register or login first.');
        }

        // Check if the car is already booked
        $rental = Rental::where('car_id', $car->id)
            ->where('status', 'pending') // Only consider rentals with status 'pending'
            ->first();

        if ($rental) {
            return view('cars.details', compact('car', 'rental'))->with('error', 'This car is currently booked.');
        }

        return view('cars.details', compact('car'));
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
            return redirect()->route('car.details', $car->id)->with('error', 'Car is already booked for the selected dates.');
        }

        // Calculate the total cost based on the rental duration
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDays = $startDate->diffInDays($endDate);
        $totalCost = $totalDays * $car->daily_rent_price;

        // Create the rental record
        Rental::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $totalCost,
            'status' => 'pending',
        ]);

        // Mark the car as not available
        $car->update([
            'availability' => false,
        ]);

        // Redirect to the customer's dashboard or a success page
        return redirect()->route('customer.dashboard')->with('success', 'Your rental has been successfully booked.');
    }


    // Login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in using the built-in Laravel Auth system
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Redirect based on the user's role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
            }

            return redirect()->route('customer.dashboard'); // Redirect to customer dashboard
        }

        // If authentication fails, return with an error
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    
    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/'); // Redirect to the home page or login page
    }

    // Register form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('customer.dashboard');
    }

    // About page
    public function about()
    {
        return view('pages.about');
    }

    // Contact page
    public function contact()
    {
        return view('pages.contact');
    }

    // Terms and conditions page
    public function terms()
    {
        return view('pages.terms');
    }

    // for form submission on contact page
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        Contact::create($request->all());

        return redirect()->back()->with('success', 'Message sent successfully!');
    }


    public function contactSubmit(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|min:5',
        ]);

        // Save to database (Optional)
        Contact::create($validated); // Ensure you have a Contact model & migration

        // Send email notification (Optional)
        Mail::to('admin@yourcarrental.com')->send(new ContactMail($validated));

        // Redirect with success message
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
