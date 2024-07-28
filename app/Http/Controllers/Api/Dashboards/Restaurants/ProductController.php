<?php

namespace App\Http\Controllers\Api\Dashboards\Restaurants;

use App\Enums\NotificationsMsg;
use App\Http\Requests\ProductRequest;
use App\Notifications\AppNotification;
use App\Services\CRUD\RestaurantProductsCrud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProductController
{
  public function __construct(
    private RestaurantProductsCrud $restaurantProductCrud
  ) {
  }

  public function index(): object
  {
    $products = $this->restaurantProductCrud->read();

    return response()->json([
      'products' => $products,
    ]);
  }

  public function store(ProductRequest $request)
  {
    $this->restaurantProductCrud->create($request);

    Notification::send(Auth::guard('restaurant')->user(), new AppNotification(NotificationsMsg::PRODUCT_CREATED));
  }

  public function update(ProductRequest $request, int $id)
  {
    $this->restaurantProductCrud->update($request, $id);

    Notification::send(Auth::guard('restaurant')->user(), new AppNotification(NotificationsMsg::PRODUCT_UPDATED));
  }

  public function destroy(int $id)
  {
    $this->restaurantProductCrud->delete($id);

    Notification::send(Auth::guard('restaurant')->user(), new AppNotification(NotificationsMsg::PRODUCT_DELETED));
  }
}
