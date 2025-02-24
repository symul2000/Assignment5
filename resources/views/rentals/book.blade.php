@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Book Car: {{ $car->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('rentals.create') }}" method="POST">
        @csrf
        <input type="hidden" name="car_id" value="{{ $car->id }}">
    
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" required>
    
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" required>
    
        <label for="total_cost">Total Cost:</label>
        <input type="number" name="total_cost" required>
    
        <button type="submit">Book Car</button>
    </form>
    
</div>
@endsection
