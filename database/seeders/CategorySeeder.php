<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  private $categories = ['american', 'sandwiches', 'tacos', 'pizza', 'hot dogs', 'ice cream', 'traditional'];
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    foreach ($this->categories as $category) {
      $categories = new Category();
      $categories->name = $category;
      $categories->save();
    }
  }
}
