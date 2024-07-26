<?php

namespace App\Http\Controllers\Auth\Restaurants;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RestaurantsLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
  /**
   * Handle an incoming authentication request.
   */
  public function store(RestaurantsLoginRequest $request): Response
  {
    $request->authenticate();

    $request->session()->regenerate();

    return response()->noContent();
  }

  /**
   * Destroy an authenticated session.
   */
  public function destroy(Request $request): Response
  {
    Auth::guard('restaurant')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return response()->noContent();
  }
}
