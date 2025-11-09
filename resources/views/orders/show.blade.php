@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Order #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5>Order Details</h5>
        </div>
        <div class="card-body">
            <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Created At:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Order Items</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price (Each)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item) <!-- Assumes eager loading -->
                        <tr>
                            <td>{{ $item->product->name }}</td> <!-- Assumes eager loading of product within orderItem -->
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection