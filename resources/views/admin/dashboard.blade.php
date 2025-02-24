@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-center">Admin Dashboard - Rentals</h2>

    @if($rentals->isEmpty())
        <div class="alert alert-info text-center mt-4">
            <h4>No rentals found!</h4>
            <p>No one has rented a car yet. Once a customer makes a booking, details will appear here.</p>
            <img src="{{ asset('storage/no-data.png') }}" alt="No rentals" class="img-fluid mt-3" style="max-width: 300px;">
        </div>
    @else
        <table class="table table-striped mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Car</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Cost</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                    <tr>
                        <td>{{ $rental->id }}</td>
                        <td>{{ $rental->user->name }}</td>
                        <td>{{ $rental->car->name }} ({{ $rental->car->model }})</td>
                        <td>{{ $rental->start_date }}</td>
                        <td>{{ $rental->end_date }}</td>
                        <td>TK{{ number_format($rental->total_cost, 2) }}</td>
                        <td>
                            <span class="badge 
                                {{ $rental->status == 'Ongoing' ? 'badge-primary' : ($rental->status == 'Completed' ? 'badge-success' : 'badge-danger') }}">
                                {{ $rental->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.rentals.edit', $rental->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.rentals.destroy', $rental->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection



<style>
    .badge-primary {
        background-color: #007bff !important; /* Strong blue */
        color: white !important; /* White text */
    }

    .badge-success {
        background-color: #28a745 !important; /* Green */
        color: white !important;
    }

    .badge-danger {
        background-color: #dc3545 !important; /* Red */
        color: white !important;
    }

    .badge-secondary {
        background-color: #6c757d !important; /* Gray */
        color: white !important;
    }
</style>
