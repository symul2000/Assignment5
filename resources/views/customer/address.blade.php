@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Update Address</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('customer.address.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="{{ auth()->user()->address }}" required>
        </div>
        <div class="mb-3">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="{{ auth()->user()->city }}" required>
        </div>
        <div class="mb-3">
            <label>Zip Code</label>
            <input type="text" name="zip_code" class="form-control" value="{{ auth()->user()->zip_code }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Address</button>
    </form>
</div>
@endsection
