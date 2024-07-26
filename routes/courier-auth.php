<?php

use App\Http\Controllers\Auth\Couriers\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::prefix('couriers')->name('couriers.')->group(function () {

  Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login')->middleware('guest:courier');
  Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth:courier');
});
