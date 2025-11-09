<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\CustomerService; // Need this to list customers for the order form
use App\Http\Requests\PlaceOrderRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected $orderService;
    protected $customerService; 

    
    public function __construct(OrderService $orderService, CustomerService $customerService)
    {
        $this->orderService = $orderService;
        $this->customerService = $customerService;
    }

    public function index(): View
    {
        
        $orders = $this->orderService->getAllOrders();
        return view('orders.index', compact('orders'));
    }

    
    public function showCart(): View
    {
        $cartItems = $this->orderService->getCartItems();
        $total = $this->orderService->getCartTotal();
        $customers = $this->customerService->getAllCustomers(); 

        return view('orders.cart', compact('cartItems', 'total', 'customers'));
    }

   
    public function addToCart(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->orderService->addToCart($request->product_id, $request->quantity);

        return redirect()->back()->with('success', 'Item added to cart!');
    }

   
    public function removeFromCart(int $productId): RedirectResponse
    {
        $this->orderService->removeFromCart($productId);
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    
    public function updateCart(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0', // Allow 0 to remove via update
        ]);

         $this->orderService->updateCartQuantity($request->product_id, $request->quantity);

        
         $message = $request->quantity == 0 ? 'Item removed from cart!' : 'Cart updated!';
         return redirect()->back()->with('success', $message);
    }

   
    public function placeOrder(PlaceOrderRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $result = $this->orderService->placeOrder($validatedData['customer_id']);

        if ($result['success']) {
            return redirect()->route('orders.index')->with('success', $result['message']);
        } else {
          
            return redirect()->back()->withErrors(['order' => $result['message']])->withInput();
        }
    }

   
    public function show(int $id): View
    {
        
        $order = $this->orderService->getOrderById($id);
        if (!$order) {
            abort(404, 'Order not found');
        }
        return view('orders.show', compact('order'));
    }
}