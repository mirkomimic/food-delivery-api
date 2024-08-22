<?php

namespace App\Http\Controllers\Api\Shop;

use App\Enums\NotificationsMsg;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Notifications\AppNotification;
use App\Services\CRUD\Orders\UserOrdersCrud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{

  public function __construct(
    protected UserOrdersCrud $userOrdersCrud
  ) {}

  public function index() {}

  public function store(OrderRequest $request)
  {
    $order = $this->userOrdersCrud->create($request);

    Notification::send(Auth::guard('web')->user(), new AppNotification(NotificationsMsg::ORDER_CREATED));

    return response([
      'order' => $order
    ], Response::HTTP_CREATED);
  }

  public function update(Request $request, string $id)
  {
    //
  }

  public function destroy(string $id)
  {
    //
  }
}
