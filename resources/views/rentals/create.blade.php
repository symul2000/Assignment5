@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2 class="text-center mb-4">Book {{ $car->name }} ({{ $car->brand }})</h2>

    <div class="card">
        <div class="text-center mt-3">
            <img src="{{ asset('storage/cars/'.$car->image) }}" class="img-fluid rounded" style="max-width: 400px; height: auto;" alt="{{ $car->name }}">
        </div>
        <div class="card-body">
            <p><strong>Model:</strong> {{ $car->model }}</p>
            <p><strong>Year:</strong> {{ $car->year }}</p>
            <p><strong>Price per day:</strong> ${{ $car->daily_rent_price }}</p>

            @if(auth()->check())
                <form action="{{ route('rentals.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="total_cost">Total Cost:</label>
                        <input type="number" name="total_cost" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mt-3">Confirm Booking</button>
                </form>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary btn-block mt-3">Register to Book</a>
            @endif
        </div>
    </div>
</div>
@endsection
