<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('order_products', function (Blueprint $table) {
      $table->foreignIdFor(Order::class);
      $table->foreignIdFor(Product::class);
      $table->integer('quantity')->default(1);
      $table->integer('total')->nullable();
      $table->timestamps();

      $table->unique(['order_id', 'product_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('order_products');
  }
};
