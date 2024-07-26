<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
  private $statuses = ['awaiting', 'accepted', 'delivered'];
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    foreach ($this->statuses as $status) {
      $orderStatus = new OrderStatus();
      $orderStatus->status = $status;
      $orderStatus->save();
    }
  }
}
