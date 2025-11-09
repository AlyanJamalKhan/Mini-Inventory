@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Customer: {{ $customer->name }}</h1>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to Customers</a>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Details</h5>
            <p><strong>ID:</strong> {{ $customer->id }}</p>
            <p><strong>Name:</strong> {{ $customer->name }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
@endsection