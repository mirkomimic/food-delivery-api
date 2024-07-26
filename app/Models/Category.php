<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
  use HasFactory;

  public $timestamps = false;

  public function restaurants(): BelongsToMany
  {
    return $this->belongsToMany(Restaurant::class, 'restaurant_categories');
  }
}
