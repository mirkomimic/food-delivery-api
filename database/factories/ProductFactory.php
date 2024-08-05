<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Services\FilesCrud\SingleFileCrud;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
  protected static $image;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {

    // $faker = \Faker\Factory::create();
    // $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));

    return [
      'restaurant_id' => Restaurant::factory(),
      // 'name' => $faker->foodName(),
      'name' => fake()->word(),
      'price' => fake()->numberBetween(1, 20000),
      'image' => static::$image ??= function () {
        $singleFileCrud = new SingleFileCrud();
        $image = UploadedFile::fake()->image('photo1.jpg');
        $singleFileCrud->save('images/products', $image);
        return $image->hashName();
      }
    ];
  }
}
