<?php

use App\Http\Controllers\Api\Dashboards\Restaurants\HomeController as RestaurantsHomeController;
use App\Http\Controllers\Api\Dashboards\Restaurants\ProductController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\Shop\OrderController;
use App\Http\Controllers\Api\Shop\RestaurantProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
  $user = $request->user();
  $guards = ['web', 'restaurant', 'courier'];
  $guardInfo = '';

  foreach ($guards as $guard) {
    if (Auth::guard($guard)->check()) {
      $guardInfo = $guard;
    };
  }

  $user->guard = $guardInfo;

  return $user;
});

// https://stackoverflow.com/questions/47643417/post-http-localhost8000-broadcasting-auth-403-forbidden
Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::name('dashboard.restaurant.')->middleware('auth:restaurant')->group(function () {

  Route::resource('dashboard/restaurant/home', RestaurantsHomeController::class)->only(['index']);

  Route::resource('dashboard/restaurant/products', ProductController::class)->only(['index', 'store', 'update', 'destroy']);
});

Route::resource('restaurant.products', RestaurantProductsController::class)->only('index');

Route::resource('orders', OrderController::class)->only('store');
