@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Book Car: {{ $car->name }}</h2>
    <p><strong>Price per day:</strong> ${{ $car->daily_rent_price }}</p>

    <h4>Booked Dates:</h4>
    <ul>
        @foreach($bookedDates as $dates)
            <li>{{ $dates['start_date'] }} to {{ $dates['end_date'] }}</li>
        @endforeach
    </ul>

    <!-- Display Error Message if Car is Already Booked -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('rentals.create') }}" method="POST">
        @csrf
        <input type="hidden" name="car_id" value="{{ $car->id }}">

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" name="start_date" id="start_date" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" name="end_date" id="end_date" required>
        </div>

        <h5>Total Cost: <span id="totalCost"> $0.00</span></h5>

        <button type="submit" class="btn btn-success">Confirm Booking</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let startDateInput = document.getElementById("start_date");
        let endDateInput = document.getElementById("end_date");
        let totalCostDisplay = document.getElementById("totalCost");
        let dailyPrice = {{ $car->daily_rent_price }};

        function calculateTotalCost() {
            let startDate = new Date(startDateInput.value);
            let endDate = new Date(endDateInput.value);

            if (!isNaN(startDate) && !isNaN(endDate) && endDate >= startDate) {
                let diffTime = Math.abs(endDate - startDate);
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Include start and end date
                let totalCost = diffDays * dailyPrice;
                totalCostDisplay.textContent = "TK" + totalCost.toFixed(2);
            } else {
                totalCostDisplay.textContent = "TK0.00";
            }
        }

        startDateInput.addEventListener("change", calculateTotalCost);
        endDateInput.addEventListener("change", calculateTotalCost);
    });
</script>
@endsection
