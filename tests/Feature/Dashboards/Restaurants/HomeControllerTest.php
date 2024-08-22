<?php

namespace Tests\Feature\Dashboards\Restaurants;

use App\Models\Courier;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
  use RefreshDatabase;

  public function test_index()
  {
    $restaurant = Restaurant::find(Restaurant::factory()->create()->id);
    User::factory()->create();
    Courier::factory()->create();
    Order::factory()->for($restaurant)->count(2)->create();

    $response = $this->actingAs($restaurant, 'restaurant')
      ->get(route('dashboard.restaurant.home.index'))->assertOk();

    $this->assertEquals(2, $response['last7DaysCount'][0]['order_count']);
  }
}
