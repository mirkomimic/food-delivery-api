<?php

namespace App\Http\Controllers\Api\Dashboards\Restaurants;

use App\Enums\NotificationsMsg;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Notifications\AppNotification;
use App\Services\CRUD\RestaurantProductsCrud;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class ProductController
{
  public function __construct(
    private RestaurantProductsCrud $restaurantProductCrud
  ) {
  }

  public function index(): object
  {
    $products = $this->restaurantProductCrud->read();

    return response([
      'products' => $products
    ], Response::HTTP_OK);
  }

  public function store(ProductRequest $request)
  {
    $product = $this->restaurantProductCrud->create($request);

    Notification::send(Auth::guard('restaurant')->user(), new AppNotification(NotificationsMsg::PRODUCT_CREATED));

    return response([
      'product' => $product
    ], Response::HTTP_CREATED);
  }

  public function update(ProductRequest $request, int $id)
  {
    $product = $this->restaurantProductCrud->update($request, $id);

    Notification::send(Auth::guard('restaurant')->user(), new AppNotification(NotificationsMsg::PRODUCT_UPDATED));

    return response([
      'product' => $product
    ], Response::HTTP_OK);
  }

  public function destroy(int $id)
  {
    $product = $this->restaurantProductCrud->delete($id);

    Notification::send(Auth::guard('restaurant')->user(), new AppNotification(NotificationsMsg::PRODUCT_DELETED));

    return response($product, Response::HTTP_NO_CONTENT);
  }
}
