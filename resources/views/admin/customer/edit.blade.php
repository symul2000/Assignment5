@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Customer</h1>
    
    <form action="{{ route('admin.customer.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $customer->email }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.customer.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
    