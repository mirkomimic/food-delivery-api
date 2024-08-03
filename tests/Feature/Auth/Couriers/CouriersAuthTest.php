<?php

namespace Tests\Feature\Auth\Couriers;

use App\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CouriersAuthTest extends TestCase
{
  use RefreshDatabase;

  public function test_couriers_can_authenticate_using_login_screen(): void
  {
    $courier = Courier::factory()->create();

    $this->post(route('couriers.login'), [
      'email' => $courier->email,
      'password' => 'password'
    ])->assertNoContent();

    $this->assertAuthenticated('courier');
    $this->assertAuthenticatedAs($courier, 'courier');
  }

  public function test_couriers_can_not_authenticate_with_invalid_password(): void
  {
    $courier = Courier::factory()->create();

    $this->post(route('couriers.login'), [
      'email' => $courier->email,
      'password' => 'wrong password'
    ]);

    $this->assertGuest('courier');
  }

  public function test_couriers_can_logout(): void
  {
    $courier = Courier::find(Courier::factory()->create()->id);

    $this->actingAs($courier, 'courier')
      ->post(route('couriers.logout'))
      ->assertNoContent();

    $this->assertGuest('courier');
  }
}
