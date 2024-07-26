<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return ['Laravel' => app()->version()];
});

// Broadcast::routes();
// Broadcast::routes();

require __DIR__ . '/auth.php';
require __DIR__ . '/restaurant-auth.php';
require __DIR__ . '/courier-auth.php';
