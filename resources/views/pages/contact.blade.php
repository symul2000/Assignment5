@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="container my-5">
    <div class="text-center">
        <h1 class="mb-3">Contact Us</h1>
        <p class="lead">We’d love to hear from you! Reach out to us for any inquiries or support.</p>
    </div>  

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Send Message</button>
            </form>
        </div>
    </div>

    <div class="text-center mt-5">
        <h4>Our Contact Information</h4>
        <p><strong>Phone:</strong> +880 1234 567 890</p>
        <p><strong>Email:</strong> info@yourcarrental.com</p>
        <p><strong>Address:</strong> 123 Rental Street, Dhaka, Bangladesh</p>
    </div>
</div>
@endsection
