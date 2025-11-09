<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Inventory & Orders Management</title>
    <!-- Bootstrap or your preferred CSS framework can be included here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Inventory System</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
                <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                <a class="nav-link" href="{{ route('customers.index') }}">Customers</a>
                <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                <a class="nav-link" href="{{ route('cart.index') }}">Cart ({{ count(session()->get('cart', [])) }})</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>