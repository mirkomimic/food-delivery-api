<?php

namespace App\Models;

use App\Models\Traits\Relationships\OrderRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory, OrderRelationships;
}
