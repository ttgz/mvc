<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Services\AuthServiceApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends BaseController
{
    use AuthServiceApi;
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'password');
        $user = User::create($data);

        if (!$user) {
            return response()->json(['error' => 'Registration failed'], 400);
        }

        return response()->json(['message' => 'User registered successfully'], 201);
    }
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    protected function respondWithToken($token)
    {
        $ttl = config('jwt.ttl'); // Get the TTL from the JWT configuration
        $expiration = Carbon::now()->addMinutes($ttl);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl * 60,
            'expires_at' => $expiration->toDateTimeString()
        ]);
    }
}
