@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Booking Successful!</h2>
    <p>Your car has been booked successfully. We will contact you soon.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
</div>
@endsection
