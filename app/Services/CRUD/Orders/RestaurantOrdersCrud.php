<?php

namespace App\Services\CRUD\Orders;

use App\Models\Restaurant;
use App\Services\CRUD\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantOrdersCrud extends Crud
{
  protected int $restaurant_id;

  public function __construct()
  {
    $this->restaurant_id = Auth::guard('restaurant')->user()->id;
  }

  public function create(Request $request) {}

  public function read(): object
  {
    $restaurant = Restaurant::find($this->restaurant_id);
    $orders = $restaurant->orders;

    return $orders;
  }

  public function update(Request $request, int $id) {}

  public function delete(int $id) {}
}
