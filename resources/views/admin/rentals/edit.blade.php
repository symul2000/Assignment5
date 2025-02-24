@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-center">Edit Rental</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.rentals.update', $rental->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- User Selection -->
                <div class="form-group">
                    <label for="user_id">Select User:</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">-- Select User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $rental->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Car Selection -->
                <div class="form-group">
                    <label for="car_id">Select Car:</label>
                    <select name="car_id" id="car_id" class="form-control" required>
                        <option value="">-- Select Car --</option>
                        @foreach($cars as $car)
                            <option value="{{ $car->id }}" {{ $rental->car_id == $car->id ? 'selected' : '' }}>
                                {{ $car->name }} ({{ $car->model }} - {{ $car->year }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Start Date -->
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $rental->start_date }}" required>
                </div>

                <!-- End Date -->
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $rental->end_date }}" required>
                </div>

                <!-- Total Cost (Automatically calculated) -->
                <div class="form-group">
                    <label for="total_cost">Total Cost ($):</label>
                    <input type="number" name="total_cost" id="total_cost" class="form-control" value="{{ $rental->total_cost }}" readonly>
                </div>

                <!-- Rental Status -->
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Ongoing" {{ $rental->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="Completed" {{ $rental->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ $rental->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mt-3">Update Rental</button>
                <a href="{{ route('admin.rentals.index') }}" class="btn btn-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const totalCostInput = document.getElementById('total_cost');
    const carSelect = document.getElementById('car_id');
    
    const carPrices = @json($cars->pluck('daily_rent_price', 'id'));

    function calculateTotalCost() {
        let startDate = new Date(startDateInput.value);
        let endDate = new Date(endDateInput.value);
        let carId = carSelect.value;
        
        if (!isNaN(startDate) && !isNaN(endDate) && carPrices[carId]) {
            let days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
            let totalCost = days * carPrices[carId];
            totalCostInput.value = totalCost > 0 ? totalCost : 0;
        }
    }

    startDateInput.addEventListener('change', calculateTotalCost);
    endDateInput.addEventListener('change', calculateTotalCost);
    carSelect.addEventListener('change', calculateTotalCost);
});
</script>

@endsection
