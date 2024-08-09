<?php

namespace Tests\Feature\Shop;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
  use RefreshDatabase;

  public function test_index(): void
  {
    $restaurant = Restaurant::factory()->create();
    $categories = Category::factory()->count(3)->create();
    $restaurant->categories()->syncWithoutDetaching($categories);

    $restaurant2 = Restaurant::factory()->create();
    $restaurant2->categories()->syncWithoutDetaching([1]);

    $response = $this->get(route('home'), [
      'categories' => [1]
    ])->assertOk();

    $this->assertEquals(2, count($response['restaurants']['data']));
    $this->assertEquals(3, count($response['categories']));
  }
}
