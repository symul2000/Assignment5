@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Manage Cars</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>Type</th>
                <th>Price</th>
                <th>Availability</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cars as $car)
                <tr>
                    <td>{{ $car->name }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->year }}</td>
                    <td>{{ $car->type }}</td>
                    <td>{{ $car->price }}</td>
                    <td> {{ $car->availability == 1 ? 'Yes' : 'No' }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" style="width: 100px;">
                    </td>
                    <td>
                        <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">Add New Car</a>
</div>
@endsection
