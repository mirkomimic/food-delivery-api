<?php

namespace Tests\Feature\Auth\Restaurants;

use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestaurantsAuthTest extends TestCase
{
  use RefreshDatabase;

  public function test_restaurants_can_authenticate_using_login_screen(): void
  {
    $restaurant = Restaurant::factory()->create();

    $this->post(route('restaurants.login'), [
      'email' => $restaurant->email,
      'password' => 'password'
    ])->assertNoContent();

    $this->assertAuthenticated('restaurant');
    $this->assertAuthenticatedAs($restaurant, 'restaurant');
  }

  public function test_restaurants_can_not_authenticate_with_invalid_password(): void
  {
    $restaurant = Restaurant::factory()->create();

    $this->post(route('restaurants.login'), [
      'email' => $restaurant->email,
      'password' => 'wrong password'
    ]);

    $this->assertGuest('restaurant');
  }

  public function test_restaurants_can_logout(): void
  {
    $restaurant = Restaurant::find(Restaurant::factory()->create()->id);

    $this->actingAs($restaurant, 'restaurant')
      ->post(route('restaurants.logout'))
      ->assertNoContent();

    $this->assertGuest('restaurant');
  }
}
