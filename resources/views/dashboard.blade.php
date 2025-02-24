@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ auth()->user()->name }}!</h1>

    <h2>Your Rentals:</h2>

    @if($rentals->isEmpty())
        <p>You don't have any current rentals.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Car</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Cost</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                    <tr>
                        <td>{{ $rental->car->name }}</td>
                        <td>{{ $rental->start_date }}</td>
                        <td>{{ $rental->end_date }}</td>
                        <td>TK{{ number_format($rental->total_cost, 2) }}</td>
                        <td>
                            <span class="badge 
                                {{ $rental->rental_status == 'Ongoing' ? 'badge-primary' : ($rental->rental_status == 'Completed' ? 'badge-success' : 'badge-danger') }}">
                                {{ ucfirst($rental->rental_status) }}
                            </span>
                        </td>
                        <td>
                            @if(\Carbon\Carbon::parse($rental->start_date)->isFuture())
                                <form action="{{ route('rentals.cancel', $rental->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Cancel Booking</button>
                                </form>
                            @else
                                <span class="text-muted">Cannot cancel</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
