@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Product: {{ $product->name }}</h1>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Details</h5>
            <p><strong>ID:</strong> {{ $product->id }}</p>
            <p><strong>Name:</strong> {{ $product->name }}</p>
            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
@endsection