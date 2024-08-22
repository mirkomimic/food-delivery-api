<?php

namespace Database\Factories;

use App\Models\Courier;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'user_id' => User::all('id')->random(),
      'restaurant_id' => Restaurant::all('id')->random(),
      'courier_id' => Courier::all('id')->random(),
    ];
  }
}
