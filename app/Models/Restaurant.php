<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class Restaurant extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens;

  protected $quard = 'restaurant';

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function categories(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'restaurant_categories');
  }

  public function products(): HasMany
  {
    return $this->hasMany(Product::class);
  }

  // https://laravel.com/docs/11.x/eloquent#local-scopes
  public function scopeFilter(Builder $query, Request $request)
  {
    $query->when($request->categories, function (Builder $query, $value) {
      $query->whereHas('categories', function ($q) use ($value) {
        $q->whereIn('category_id', $value);
      });
    });
  }
}
