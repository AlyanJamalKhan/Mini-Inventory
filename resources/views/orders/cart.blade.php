@extends('layouts.app')

@section('content')
    <h1>Your Cart</h1>

    @if(empty($cartItems))
        <p>Your cart is empty.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $productId => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.update') }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="product_id" value="{{ $productId }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm d-inline w-auto">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                            </form>
                        </td>
                        <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $productId) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this item?')">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total:</th>
                    <th>${{ number_format($total, 2) }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <hr>

        <h3>Place Order</h3>
        <form action="{{ route('orders.place') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="customer_id" class="form-label">Select Customer</label>
                <select name="customer_id" id="customer_id" class="form-control" required>
                    <option value="">Choose a customer...</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Place Order</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
        </form>
    @endif
@endsection