<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB; // Needed for transactions
use Illuminate\Support\Facades\Session; // Needed for session cart

class OrderService
{
    protected $orderRepository;
    protected $productRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, ProductRepositoryInterface $productRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    // --- Cart Management using Session ---
    public function addToCart(int $productId, int $quantity = 1): void
    {
        $cart = Session::get('cart', []);
        $product = $this->productRepository->findById($productId);

        if (!$product) {
            // Handle product not found error if necessary, though validation should catch this earlier
            return;
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);
    }

    public function getCartItems()
    {
        return Session::get('cart', []);
    }

    public function removeFromCart(int $productId): void
    {
        $cart = Session::get('cart', []);
        unset($cart[$productId]);
        Session::put('cart', $cart);
    }

    public function updateCartQuantity(int $productId, int $newQuantity): void
    {
        if ($newQuantity <= 0) {
            $this->removeFromCart($productId);
            return;
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
             $cart[$productId]['quantity'] = $newQuantity;
             Session::put('cart', $cart);
        }
    }

    public function clearCart(): void
    {
        Session::forget('cart');
    }

    public function getCartTotal(): float
    {
        $total = 0;
        foreach ($this->getCartItems() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    // --- Order Placement Logic ---
    public function placeOrder(int $customerId): array // Returns ['success' => bool, 'message' => string, 'order' => ?Order]
    {
        $cartItems = $this->getCartItems();

        if (empty($cartItems)) {
            return ['success' => false, 'message' => 'Cannot place an order with an empty cart.', 'order' => null];
        }

        $totalAmount = $this->getCartTotal();

        // 8. Prevent ordering when stock is insufficient.
        foreach ($cartItems as $itemId => $itemData) {
            if (!$this->isStockSufficient($itemId, $itemData['quantity'])) {
                 return ['success' => false, 'message' => "Insufficient stock for item: {$itemData['name']}.", 'order' => null];
            }
        }

        DB::beginTransaction(); // 6. Handle order placement using transactions.

        try {
            // 5. Create Order
            $orderData = [
                'customer_id' => $customerId,
                'total_amount' => $totalAmount,
                'status' => 'pending', // Or another initial status
            ];

            $order = $this->orderRepository->create($orderData);

            if (!$order) {
                DB::rollBack();
                return ['success' => false, 'message' => 'Failed to create order.', 'order' => null];
            }

            // 5. Create Order Items & 7. Reduce product stock when an order is placed.
            foreach ($cartItems as $productId => $itemData) {
                $orderItemData = [
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'], // Price at time of order
                ];

                OrderItem::create($orderItemData); // Create directly, or use an OrderItem repository if preferred

                // Update stock
                $product = $this->productRepository->findById($productId);
                if ($product) {
                    $product->decrement('stock', $itemData['quantity']); // 7. Reduce stock
                }
            }

            DB::commit(); // Commit the transaction

            $this->clearCart(); // Clear the cart after successful order

            return ['success' => true, 'message' => 'Order placed successfully!', 'order' => $order];

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            \Log::error('Order placement failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred while placing the order: ' . $e->getMessage(), 'order' => null];
        }
    }

    // --- Added Methods ---
    public function getAllOrders()
    {
        // Delegate the fetching of all orders to the repository
        return $this->orderRepository->all();
    }

    public function getOrderById(int $id)
    {
        // Delegate the fetching of a specific order to the repository
        // The repository implementation should handle eager loading of customer and orderItems
        return $this->orderRepository->findById($id);
    }
    // --- End of Added Methods ---


    // Helper function to check stock
    private function isStockSufficient(int $productId, int $quantity): bool
    {
        $product = $this->productRepository->findById($productId);
        return $product && $product->stock >= $quantity;
    }
}