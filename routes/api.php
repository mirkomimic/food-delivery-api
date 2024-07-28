<?php

use App\Http\Controllers\Api\Dashboards\Restaurants\ProductController;
use App\Http\Controllers\Api\HomeController;
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

// Broadcast::routes();
Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::post('/broadcasting/auth', function () {
  return Auth::user();
});

Route::get('/test', [HomeController::class, 'index'])->middleware('auth:sanctum');

Route::resource('dashboard/restaurant/products', ProductController::class)->only(['index', 'store', 'update', 'destroy']);
