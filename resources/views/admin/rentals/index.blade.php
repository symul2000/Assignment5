@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Manage Rentals</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Car</th>
                <th>User</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Cost</th>
                <th>Status</th>
                <th>Cancellable</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $rental)
            <tr>
                <td>{{ $rental->id }}</td>
                <td>{{ $rental->car->model ?? 'N/A' }}</td>
                <td>{{ $rental->user->name ?? 'N/A' }}</td>
                <td>{{ $rental->start_date }}</td>
                <td>{{ $rental->end_date }}</td>
                <td>TK{{ number_format($rental->total_cost, 2) }}</td>
                <td>
                    @if($rental->status === 'Ongoing')
                        <span class="badge bg-warning">Ongoing</span>
                    @elseif($rental->status === 'Completed')
                        <span class="badge bg-success">Completed</span>
                    @elseif($rental->status === 'Cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($rental->status) }}</span>
                    @endif
                </td>
                <td>
                    @if($rental->cancellable)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-danger">No</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.rentals.edit', $rental->id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('admin.rentals.destroy', $rental->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>

                    @if($rental->cancellable)
                    <form action="{{ route('admin.rentals.cancel', $rental->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Cancel this rental?')">Cancel</button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-sm" disabled>Not Cancellable</button>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
