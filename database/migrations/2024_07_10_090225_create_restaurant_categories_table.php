<?php

use App\Models\Category;
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
    Schema::create('restaurant_categories', function (Blueprint $table) {
      $table->unique(['restaurant_id', 'category_id']);
      $table->foreignIdFor(Restaurant::class);
      $table->foreignIdFor(Category::class);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('restaurant_categories');
  }
};
