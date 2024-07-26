<?php

namespace App\Services\CRUD;

use App\Models\Product;
use App\Models\Restaurant;
use App\Services\FilesCrud\SingleFileCrud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantProductsCrud extends Crud
{
  protected int $restaurant_id;

  public function __construct(
    private SingleFileCrud $singleFileCrud
  ) {
    $this->restaurant_id = Auth::guard('restaurant')->user()->id;
  }

  public function create(Request $request): void
  {
    $product = new Product();
    $product->name = $request->name;
    $product->price = $request->price;
    $product->restaurant_id = $this->restaurant_id;

    if ($request->hasFile('image')) {
      $this->singleFileCrud->save('images/products', $request->image);
      $product->image = $request->image->hashName();
    }

    $product->save();
  }

  public function read(): object
  {
    $restaurant = Restaurant::find($this->restaurant_id);
    $products = $restaurant->products;

    return $products;
  }

  public function update(Request $request, int $id)
  {
  }

  public function delete(int $id)
  {
  }
}
