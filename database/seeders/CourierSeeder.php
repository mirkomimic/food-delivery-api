<?php

namespace Database\Seeders;

use App\Models\Courier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Courier::factory()->create([
      'name' => 'test courier',
      'email' => 'courier@test.com',
    ]);

    Courier::factory(10)->create();
  }
}
