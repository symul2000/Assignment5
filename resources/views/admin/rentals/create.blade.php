@extends('layouts.admin') 

@section('content')
<div class="container">
    <h2>Create New Rental</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rentals.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">Customer</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">Select a Customer</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="car_id" class="form-label">Car</label>
            <select name="car_id" id="car_id" class="form-control" required>
                <option value="">Select a Car</option>
                @foreach ($cars as $car)
                    <option value="{{ $car->id }}">{{ $car->model }} ({{ $car->license_plate }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="total_cost" class="form-label">Total Cost</label>
            <input type="number" name="total_cost" id="total_cost" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Rental</button>
    </form>
</div>
@endsection
