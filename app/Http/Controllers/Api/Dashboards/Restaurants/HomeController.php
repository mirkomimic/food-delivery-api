<?php

namespace App\Http\Controllers\Api\Dashboards\Restaurants;

use App\Models\Order;
use App\Services\Stats\RestaurantOrdersStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
  protected int $restaurant_id;

  public function __construct(
    protected RestaurantOrdersStats $restaurantOrdersStats
  ) {
    $this->restaurant_id = Auth::guard('restaurant')->user()->id;
  }

  public function index()
  {
    $last7DaysOrderCount = $this->restaurantOrdersStats->last7DaysCount($this->restaurant_id);

    $ordersTotalMonthly = $this->restaurantOrdersStats->ordersTotalMonthly($this->restaurant_id);

    return response([
      'last7DaysOrderCount' => $last7DaysOrderCount,
      'ordersTotalMonthly' => $ordersTotalMonthly
    ], Response::HTTP_OK);
  }
}
