<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
  use HasFactory;

  public function restaurant(): BelongsTo
  {
    return $this->belongsTo(Restaurant::class);
  }

  public function filter(Builder $builder, array $filters)
  {
  }
}
