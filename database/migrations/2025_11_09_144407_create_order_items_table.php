<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Assuming orders table is created first
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Assuming products table is created first
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Price *at the time of order*
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};