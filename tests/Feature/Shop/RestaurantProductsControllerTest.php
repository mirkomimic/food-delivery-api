<?php

namespace Tests\Feature\Shop;

use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestaurantProductsControllerTest extends TestCase
{
  use RefreshDatabase;

  public function test_index(): void
  {
    $restaurant = Restaurant::factory()->create();
    Product::factory()->for($restaurant)->count(4)->create();

    $response = $this->get(route('restaurant.products.index', $restaurant))->assertOk();

    $this->assertEquals(4, count($response['products']['data']));
  }
}
