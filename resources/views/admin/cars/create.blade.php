@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <h2>Add Car</h2>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Car Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Brand</label>
            <input type="text" name="brand" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Model</label>
            <input type="text" name="model" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Year</label>
            <input type="number" name="year" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Car Type</label>
            <input type="text" name="car_type" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Daily Rent Price</label>
            <input type="number" name="daily_rent_price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Availability</label>
            <select name="availability" class="form-control" required>
                <option value="1">Available</option>
                <option value="0">Not Available</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Car Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Car</button>
    </form>
</div>
@endsection
