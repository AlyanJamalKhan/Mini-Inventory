@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <h1 class="display-4">Welcome to the Mini Inventory System!</h1>
        <p class="lead">Manage your products, customers, and orders efficiently.</p>
        <hr class="my-4">
        <p>Use the navigation menu above to get started.</p>
        <a class="btn btn-primary btn-lg" href="{{ route('products.index') }}" role="button">View Products</a>
    </div>
@endsection