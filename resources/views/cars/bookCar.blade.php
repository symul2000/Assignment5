@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2>Book Car - {{ $car->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('frontend.rentals.create') }}" method="POST">
        @csrf
        <input type="hidden" name="car_id" value="{{ $car->id }}">

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="total_cost" class="form-label">Total Cost</label>
            <input type="number" name="total_cost" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Book Now</button>
    </form>
</div>
@endsection
