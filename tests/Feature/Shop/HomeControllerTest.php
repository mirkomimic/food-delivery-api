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

  public function test_index_without_params(): void
  {
    Restaurant::factory()->count(8)->create();
    Category::factory()->count(3)->create();

    $response = $this->get(route('home'))->assertOk();

    // pagination 6
    $this->assertEquals(6, count($response['restaurants']['data']));
    $this->assertEquals(3, count($response['categories']));
  }

  public function test_index_pagination(): void
  {
    Restaurant::factory()->count(8)->create();
    Category::factory()->count(3)->create();

    $response = $this->get(route('home', [
      'page' => '2'
    ]))->assertOk();

    // pagination 6
    $this->assertEquals(2, count($response['restaurants']['data']));
    $this->assertEquals(3, count($response['categories']));
  }

  public function test_index_with_params(): void
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
