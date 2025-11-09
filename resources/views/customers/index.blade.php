@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Customers</h1>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Add Customer</a>
    </div>

    @if($customers->isEmpty())
        <p>No customers found.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
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