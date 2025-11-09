@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Products</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
    </div>

    @if($products->isEmpty())
        <p>No products found.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th> <!-- Renamed from 'Actions' if adding cart here -->
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 60px; display: inline-block; margin-right: 5px;">
                            <button type="submit" class="btn btn-sm btn-success" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                Add to Cart
                            </button>
                        </form>

                        <!-- Existing View/Edit/Delete links/buttons -->
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection