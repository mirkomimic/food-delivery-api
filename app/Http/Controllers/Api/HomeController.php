<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\UserType;
use App\Notifications\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
  public function index()
  {
    // $user = User::find(1);
    $order = Order::find(1);
    // $user = $order->user;
    $products = $order->products;

    Notification::send(Auth::user(), new AppNotification('test notification'));

    return response()->json([
      'test' => $products
    ]);
  }
}
