<?php

use App\Models\Courier;
use App\Models\OrderStatus;
use App\Models\Restaurant;
use App\Models\User;
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
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(User::class);
      $table->foreignIdFor(Restaurant::class);
      $table->foreignIdFor(Courier::class)->nullable();
      $table->foreignIdFor(OrderStatus::class)->default(1);
      $table->integer('total')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('orders');
  }
};
