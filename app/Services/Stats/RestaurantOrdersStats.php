<?php

namespace App\Services\Stats;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestaurantOrdersStats
{
  public function last7DaysCount(int $restaurant_id)
  {
    $response = Order::select(
      DB::raw('DATE_FORMAT(created_at, "%d-%m") as formatted_date'),
      DB::raw('COUNT(*) as order_count')
    )
      ->groupBy(DB::raw('DATE_FORMAT(created_at, "%d-%m")'))
      ->where('restaurant_id', $restaurant_id)
      ->orderBy(DB::raw('MAX(created_at)'), 'desc')
      ->limit(7)
      ->get();

    $response = $response->sortBy('formatted_date')->values();

    return $response;
  }

  public function ordersTotalMonthly(int $restaurant_id)
  {
    $response = Order::select(
      DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
      DB::raw('SUM(total) as total_amount')
    )
      ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
      ->where('restaurant_id', $restaurant_id)
      ->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), 'asc')
      ->get();

    return $response;
  }
}
