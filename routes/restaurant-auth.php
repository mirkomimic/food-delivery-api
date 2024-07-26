<?php

use App\Http\Controllers\Auth\Restaurants\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::prefix('restaurants')->name('restaurants.')->group(function () {

  Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login')->middleware('guest:restaurant');
  Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth:restaurant');
});
