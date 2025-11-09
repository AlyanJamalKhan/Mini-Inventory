@extends('layouts.app')

@section('content')
    <h1>Orders</h1>

    @if($orders->isEmpty())
        <p>No orders found.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td> <!-- Assumes eager loading in controller/service -->
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">View Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection