<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\User\UserService;

class AuthController extends Controller
{
     protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:api', ['except' => ['login']]);
    }
      public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
     protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>config('jwt.ttl') * 60
        ]);
    }
    public function profile()
    {
        return response()->json(auth()->user());
    }
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

}
