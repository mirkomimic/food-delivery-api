<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderProductsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $orders = Order::all();
    $restaurants = Restaurant::all();
    // $products = Product::all();
    // $products = $restaurants->products;

    $orders->each(function ($order) {
      $restaurant = Restaurant::has('products')->inRandomOrder()->first();
      $products = $restaurant->products;
      $productIds = $products->random(rand(1, count($products)))->pluck('id')->toArray();

      foreach ($productIds as $productId) {
        $order->products()->syncWithoutDetaching($productId);
      }
    });
  }
}
