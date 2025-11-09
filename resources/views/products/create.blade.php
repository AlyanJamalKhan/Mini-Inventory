@extends('layouts.app')

@section('content')
    <h1>Add Product</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection