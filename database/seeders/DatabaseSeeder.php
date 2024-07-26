<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      UserSeeder::class,
      CategorySeeder::class,
      RestaurantSeeder::class,
      RestaurantCategorySeeder::class,
      OrderStatusSeeder::class,
      CourierSeeder::class,
      OrderSeeder::class,
      ProductSeeder::class,
      OrderProductsSeeder::class,
    ]);
  }
}
