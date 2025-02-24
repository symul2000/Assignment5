<?php

namespace App\Http\Controllers\Admin;   

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // Show all customers
    public function index()
    {
        $customers = User::where('role', 'customer')->get(); // Fetch only customers
        return view('admin.customer.index', compact('customers'));
    }

    // Show create form
    public function create()
    {
        return view('admin.customer.create');
    }

    // Store new customer
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        return redirect()->route('admin.customer.index')->with('success', 'Customer added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customer.edit', compact('customer'));
    }

    // Update customer
    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.customer.index')->with('success', 'Customer updated successfully!');
    }

    // Delete customer
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.customer.index')->with('success', 'Customer deleted successfully!');
    }
}