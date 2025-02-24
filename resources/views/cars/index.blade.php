@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Available Cars</h2>
    <div class="row">
        @foreach ($cars as $car)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" alt="{{ $car->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $car->name }}</h5>
                    <p class="card-text">Price per day: TK{{ $car->daily_rent_price }}</p>
                    <a href="{{ route('cars.details', $car->id) }}" class="btn btn-primary">Book Now</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
