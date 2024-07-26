<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantCategorySeeder extends Seeder
{

  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $restaurants = Restaurant::all();
    $categories = Category::all();

    $restaurants->each(function ($restaurant) use ($categories) {

      $categoryIds = $categories->random(rand(1, 3))->pluck('id')->toArray();

      foreach ($categoryIds as $categoryId) {
        $restaurant->categories()->syncWithoutDetaching($categoryId);
      }
    });
  }
}
