@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <h2>Edit Car - {{ $car->name }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Car Name</label>
            <input type="text" name="name" class="form-control" value="{{ $car->name }}" required>
        </div>
        <div class="mb-3">
            <label>Brand</label>
            <input type="text" name="brand" class="form-control" value="{{ $car->brand }}" required>
        </div>
        <div class="mb-3">
            <label>Model</label>
            <input type="text" name="model" class="form-control" value="{{ $car->model }}" required>
        </div>
        <div class="mb-3">
            <label>Year</label>
            <input type="number" name="year" class="form-control" value="{{ $car->year }}" required>
        </div>
        <div class="mb-3">
            <label>Car Type</label>
            <input type="text" name="car_type" class="form-control" value="{{ $car->car_type }}" required>
        </div>
        <div class="mb-3">
            <label>Daily Rent Price</label>
            <input type="number" name="daily_rent_price" class="form-control" value="{{ $car->daily_rent_price }}" required>
        </div>
        <div class="mb-3">
            <label>Availability</label>
            <select name="availability" class="form-control" required>
                <option value="1" {{ $car->availability ? 'selected' : '' }}>Available</option>
                <option value="0" {{ !$car->availability ? 'selected' : '' }}>Not Available</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Current Image</label><br>
            <img src="{{ asset('storage/'.$car->image) }}" width="150" height="100">
        </div>

        <div class="mb-3">
            <label>Upload New Image (optional)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update Car</button>
    </form>
</div>
@endsection
