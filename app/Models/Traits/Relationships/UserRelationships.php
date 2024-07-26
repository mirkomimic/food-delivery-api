<?php

namespace App\Models\Traits\Relationships;

use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserRelationships
{
  public function orders(): HasMany
  {
    return $this->hasMany(Order::class);
  }
}
