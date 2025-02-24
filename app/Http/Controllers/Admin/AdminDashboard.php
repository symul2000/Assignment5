<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rental;
use PhpParser\Node\Stmt\Return_;

class AdminDashboard extends Controller
{
    //Show Admin Dashboard with all rentals
    public function dashboard()
    {
        // Fetch all rentals with user and car details
        $rentals = Rental::with(['user', 'car'])->get();
    
        // Debug to check if rentals are actually being retrieved
        if ($rentals->isEmpty()) {
            return redirect()->back()->with('error', 'No rentals found!');
        }
    
        // Pass the data to the admin dashboard
        return view('admin.dashboard', compact('rentals'));
    }
    





    // Update Rental Status (Admin)
    public function updateRentalStatus($rentalId, $status)
    {
        // Find the rental and update the status
        $rental = Rental::findOrFail($rentalId);
        $rental->status = $status;
        $rental->save();

        return redirect()->route('admin.dashboard')->with('success', 'Rental status updated!');
    }
}
