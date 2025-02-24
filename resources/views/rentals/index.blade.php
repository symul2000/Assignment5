@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Rentals</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Car</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $rental)
                <tr>
                    <td>{{ $rental->car->name }}</td>
                    <td>{{ $rental->start_date }}</td>
                    <td>{{ $rental->end_date }}</td>
                    <td>${{ $rental->total_price }}</td>
                    <td>{{ ucfirst($rental->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
