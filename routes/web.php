<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Optional: Basic home route
Route::get('/', [HomeController::class, '__invoke'])->name('home');

// Resource routes for Products (assuming admin access, though auth middleware isn't added yet per requirements)
Route::resource('products', ProductController::class);

// Resource routes for Customers (assuming admin access, though auth middleware isn't added yet per requirements)
Route::resource('customers', CustomerController::class);

// Routes for Orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index'); // List all orders
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show'); // Show a specific order

// Cart related routes
Route::get('/cart', [OrderController::class, 'showCart'])->name('cart.index'); // View the cart
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add'); // Add item to cart
Route::delete('/cart/remove/{productId}', [OrderController::class, 'removeFromCart'])->name('cart.remove'); // Remove item from cart
Route::put('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update'); // Update item quantity in cart

// Route to place the final order (expects customer_id from the cart view form)
Route::post('/orders/place', [OrderController::class, 'placeOrder'])->name('orders.place');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


