<?php

namespace App\Services\CRUD\Orders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\CRUD\Crud;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrdersCrud extends Crud
{
  protected User $user;

  public function __construct()
  {
    $this->user = User::find(Auth::id());
  }

  public function create(Request $request)
  {
    $validatedProducts = $this->validateProducts($request);

    $order = new Order();
    $order->user_id = $this->user->id;
    $order->restaurant_id = $validatedProducts['restaurant_id'];
    $order->save();

    $grandTotal = 0;
    foreach ($validatedProducts['products'] as $prod) {
      $grandTotal += ($prod['qty'] * $prod['price']);

      $order->products()->attach([
        $prod['id'] => [
          'quantity' => $prod['qty'],
          'total' => $prod['qty'] * $prod['price']
        ],
      ]);
    }

    $order->total = $grandTotal;
    $order->save();

    return $order;
  }

  public function read(): object
  {
    $orders = $this->user->orders;

    return $orders;
  }

  public function update(Request $request, int $id)
  {
  }

  public function delete(int $id)
  {
  }

  private function validateProducts(Request $request)
  {

    $data = [];
    try {
      foreach ($request->products as $prod) {
        $product = Product::query()->find($prod['id']);
        $data['products'][] = [
          'id' => $product->id,
          'qty' => $prod['qty'],
          'price' => $product->price,
        ];
      }

      $data['restaurant_id'] = $this->checkRestaurantIds($data['products']);
    } catch (\Throwable $th) {
      throw new Exception($th->getMessage());
    }

    return $data;
  }

  // products must be from same restaurant
  private function checkRestaurantIds(array $data)
  {
    $ids = array_column($data, 'id');
    $products = Product::whereIn('id', $ids)->get();
    $restaurantIds = $products->map(fn ($prod) => $prod->restaurant->id)->unique();

    if ($restaurantIds->count() === 1) {
      return $restaurantIds->first();
    } else {
      throw new Exception('Products must be from same restaurant');
    }
  }
}
