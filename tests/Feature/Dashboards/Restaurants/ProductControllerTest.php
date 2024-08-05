<?php

namespace Tests\Feature\Dashboards\Restaurants;

use App\Models\Product;
use App\Models\Restaurant;
use App\Notifications\AppNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
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
      ->create(['image' => null]);

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
    $image = UploadedFile::fake()->image('photo1.jpg');
    $product = Product::factory()->for($restaurant)->make(['image' => $image]);

    $response = $this->actingAs($restaurant, 'restaurant')
      ->post(route('dashboard.restaurant.products.store'), [
        'name' => $product->name,
        'price' => $product->price,
        'image' => $product->image
      ])->assertCreated();

    Notification::assertSentTo($restaurant, AppNotification::class);
    $this->assertDatabaseHas('products', [
      'name' => $response['product']['name'],
      'price' => $response['product']['price'],
      'image' => $response['product']['image'],
    ]);
    $this->assertFileExists(public_path("storage/images/products/{$response['product']['image']}"));

    $this->deleteImage('images/products', $response['product']['image']);
  }

  public function test_update(): void
  {
    Notification::fake();
    $restaurant = Restaurant::find(Restaurant::factory()->create()->id);
    $image = UploadedFile::fake()->image('photo1.jpg');
    $product = Product::factory()->for($restaurant)->create(['image' => $image]);

    $response = $this->actingAs($restaurant, 'restaurant')
      ->put(route('dashboard.restaurant.products.update', $product->id), [
        'name' => 'updated name',
        'price' => $product->price,
        'image' => $product->image
      ])->assertOk();

    Notification::assertSentTo($restaurant, AppNotification::class);

    $this->assertNotEquals($product->name, $response['product']['name']);
    $this->assertDatabaseHas('products', [
      'name' => 'updated name',
    ]);
    $this->assertFileExists(public_path("storage/images/products/{$response['product']['image']}"));

    $this->deleteImage('images/products', $response['product']['image']);
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
    $this->assertFileDoesNotExist(public_path("storage/images/products/{$product->image}"));
  }
}
