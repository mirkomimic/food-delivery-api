<?php

namespace Tests\Feature\Shop;

use App\Models\OrderProducts;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OrderController extends TestCase
{
  use RefreshDatabase;

  public function test_store(): void
  {
    Notification::fake();
    $user = User::find(User::factory()->create()->id);
    $restaurant = Restaurant::factory()->create();
    Product::factory()->for($restaurant)->count(2)->create();

    $response = $this->actingAs($user, 'web')->post(
      route('orders.store'),
      [
        'products' => [
          [
            'id' => 1,
            'qty' => 2,
          ],
          [
            'id' => 2,
            'qty' => 1
          ]
        ]
      ]
    )->assertCreated();

    Notification::assertSentTo($user, AppNotification::class);
    $this->assertDatabaseHas('orders', ['id' => $response['order']['id']]);
    $this->assertDatabaseHas('order_products', ['order_id' => $response['order']['id']]);
    $this->assertEquals(2, count(OrderProducts::where('order_id', $response['order']['id'])->get()));
  }
}
