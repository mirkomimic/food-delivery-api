<?php

namespace Tests\Feature\Dashboards\Restaurants;

use App\Models\Product;
use App\Models\Restaurant;
use App\Notifications\AppNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
  use RefreshDatabase;

  public function test_index(): void
  {
    $restaurant = Restaurant::find(Restaurant::factory()->create()->id);
    $products = Product::factory()
      ->for($restaurant)
      ->count(3)
      ->create();

    $response = $this->actingAs($restaurant, 'restaurant')
      ->get(route('dashboard.restaurant.products.index'))
      ->assertOk();

    $this->assertSame(count($response['products']), 3);
    foreach ($response['products'] as $product) {
      $this->assertEquals($restaurant->id, $product['restaurant_id']);
    }
  }

  public function test_store(): void
  {
    Notification::fake();
    $restaurant = Restaurant::find(Restaurant::factory()->create()->id);
    $product = Product::factory()->for($restaurant)->make();

    $response = $this->actingAs($restaurant, 'restaurant')
      ->post(route('dashboard.restaurant.products.store'), [
        'name' => $product->name,
        'price' => $product->price
      ])->assertCreated();

    Notification::assertSentTo($restaurant, AppNotification::class);

    $this->assertSame($product->name, $response['product']['name']);
    $this->assertDatabaseHas('products', [
      'name' => $product->name,
      'price' => $product->price
    ]);
  }

  public function test_update(): void
  {
    Notification::fake();
    $restaurant = Restaurant::find(Restaurant::factory()->create()->id);
    $product = Product::factory()->for($restaurant)->create();

    $response = $this->actingAs($restaurant, 'restaurant')
      ->put(route('dashboard.restaurant.products.update', $product->id), [
        'name' => 'updated name',
        'price' => $product->price
      ])->assertOk();

    Notification::assertSentTo($restaurant, AppNotification::class);

    $this->assertNotEquals($product->name, $response['product']['name']);
    $this->assertDatabaseHas('products', [
      'name' => 'updated name',
    ]);
  }

  public function test_destroy(): void
  {
    Notification::fake();
    $restaurant = Restaurant::find(Restaurant::factory()->create()->id);
    $product = Product::factory()->for($restaurant)->create();

    $this->actingAs($restaurant, 'restaurant')
      ->delete(route('dashboard.restaurant.products.destroy', $product->id))->assertNoContent();

    Notification::assertSentTo($restaurant, AppNotification::class);

    $this->assertDatabaseMissing('products', [
      'name' => $product->name,
    ]);
  }
}
