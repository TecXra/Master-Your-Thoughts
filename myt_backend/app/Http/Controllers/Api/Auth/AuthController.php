<?php

namespace App\Http\Controllers\Api\Auth;

use Auth;
use App\Models\User;
use App\Models\UserSetting;
use App\Models\AuthProvider;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{

  // public function __construct()
  // {
  //  $this->middleware('auth:sanctum');
  // }

  public function logout(Request $request) {
    // auth()->user()->token()->revoke();
    // auth()->user()->token()->delete();
    // $request->user()->token()->delete();

    return response()->json([
      'message' => 'Successfully logged out'
    ]);
  }
}