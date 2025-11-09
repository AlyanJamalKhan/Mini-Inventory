<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerIds = DB::table('customers')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();

        if (empty($customerIds) || empty($productIds)) {
            $this->command->error('Customers or Products not found. Please run CustomerSeeder and ProductSeeder first.');
            return;
        }

        foreach ($customerIds as $customerId) { // Iterate through customers to create orders
            // Decide randomly whether this customer gets an order in this seeding run
            // Or create a fixed number of orders per customer, or total orders.
            // Let's create 1-2 orders per customer for this example.
            $numOrdersForCustomer = rand(1, 2);

            for ($i = 0; $i < $numOrdersForCustomer; $i++) {
                // Generate items for this order first to calculate total
                $itemsData = $this->generateOrderItemsData($productIds);
                $orderTotal = $itemsData['total'];
                $orderItems = $itemsData['items'];

                if (empty($orderItems)) {
                     // If generating items failed (e.g., no products with sufficient stock found)
                     // Skip creating this order.
                     continue;
                }

                // Now that total is calculated, insert the order
                $orderId = DB::table('orders')->insertGetId([
                    'customer_id' => $customerId,
                    'total_amount' => $orderTotal,
                    'status' => $this->getRandomStatus(), // e.g., 'pending', 'processing', 'shipped', 'delivered', 'cancelled'
                    'created_at' => Carbon::now()->subDays(rand(0, 30)), // Random date within last 30 days
                    'updated_at' => Carbon::now(),
                ]);

                // Insert the associated order items
                foreach ($orderItems as &$item) {
                    $item['order_id'] = $orderId; // Assign the newly created order ID
                    $item['created_at'] = $item['updated_at'] = Carbon::now();
                }
                DB::table('order_items')->insert($orderItems);
            }
        }
    }

     /**
      * Helper function to generate random order items and calculate total for an order.
      * @param array $productIds Array of available product IDs.
      * @return array ['items' => [...], 'total' => float]
      */
     private function generateOrderItemsData(array $productIds): array
     {
         $numItems = rand(1, min(3, count($productIds)));
         $selectedProductKeys = array_rand($productIds, $numItems);
         if (!is_array($selectedProductKeys)) {
             $selectedProductKeys = [$selectedProductKeys];
         }

         $orderItems = [];
         $total = 0;

         foreach ($selectedProductKeys as $key) {
             $productId = $productIds[$key];
             $product = DB::table('products')->where('id', $productId)->first();

             if ($product) {
                 // For seeding, we might just take a random quantity up to the *current* stock
                 // Or use a fixed amount if stock is high. Be careful not to deplete stock if other orders use same products.
                 // For simplicity in seeding, let's assume initial stock is high enough or pick a small quantity.
                 $quantity = rand(1, min(3, $product->stock)); // Adjust quantity logic if needed for realistic seeding

                 $itemTotal = $product->price * $quantity;
                 $orderItems[] = [
                     'product_id' => $productId,
                     'quantity' => $quantity,
                     'price' => $product->price, // Price at time of seeding/order
                     // 'order_id' and timestamps added later
                 ];
                 $total += $itemTotal;
             }
         }

         return ['items' => $orderItems, 'total' => $total];
     }

     /**
      * Helper function to get a random order status.
      * @return string
      */
     private function getRandomStatus(): string
     {
         $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
         return $statuses[array_rand($statuses)];
     }
}