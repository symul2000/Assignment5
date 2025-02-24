<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Validator;
class AdminController extends Controller
{
    // Show Admin Registration Form
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    // Register Admin User
    // public function register(Request $request)
    // {
    //     // Validate the incoming request
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|string|min:6|confirmed', // password confirmation
    //     ]);

    //     // Create the admin user
    //     $admin = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password), // Hash the password
    //         'role' => 'admin', // Assign role as admin
    //     ]);

    //     // Optionally, send a success message
    //     return redirect()->route('admin.register')->with('success', 'Admin user created successfully!');
    // }
}

