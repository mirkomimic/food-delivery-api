<?php

namespace App\Models\Traits\Relationships;

use App\Models\Courier;
use App\Models\OrderProducts;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait OrderRelationships
{
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function restaurant(): BelongsTo
  {
    return $this->belongsTo(Restaurant::class);
  }

  public function courier(): BelongsTo
  {
    return $this->belongsTo(Courier::class);
  }

  public function status(): BelongsTo
  {
    return $this->belongsTo(OrderStatus::class);
  }

  public function products(): BelongsToMany
  {
    return $this->belongsToMany(Product::class, 'order_products');
  }
}
