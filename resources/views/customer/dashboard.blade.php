@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Customer Dashboard</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5>Your Rentals</h5>
                </div>
                <div class="card-body">
                    @if($rentals->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Car</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Cost</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rentals as $rental)
                                    <tr>
                                        <td>{{ $rental->car->model }}</td>
                                        <td>{{ $rental->start_date }}</td>
                                        <td>{{ $rental->end_date }}</td>
                                        <td>TK{{ $rental->total_cost }}</td>
                                        <td>
                                            <span class="badge bg-{{ $rental->status == 'Ongoing' ? 'warning' : 'success' }}">
                                                {{ ucfirst($rental->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>You have no active rentals.</p>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('cars.index') }}" class="btn btn-primary">Book a Car</a>
            </div>
        </div>
    </div>
</div>
@endsection
