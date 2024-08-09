<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
  public function index(Request $request)
  {
    $restaurants = Restaurant::filter($request)
      ->with('categories')->paginate(6);

    $categories = Category::query()
      ->withCount('restaurants')
      ->get();

    return response()->json([
      'restaurants' => $restaurants,
      'categories' => $categories
    ]);
  }
}


// $restaurants = DB::table('restaurants')
// ->join('restaurant_categories', 'restaurants.id', '=', 'restaurant_categories.restaurant_id')
// ->join('categories', 'categories.id', '=', 'restaurant_categories.category_id')
// ->when($request->categories, function ($query, $value) {
//   $query->whereIn('categories.id', $value);
// })
// ->select('restaurants.*')
// ->distinct()
// ->paginate(6);