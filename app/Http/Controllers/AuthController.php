<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request) {
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required',
            'role'=>'required'
        ]);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        return response()->json($user);
    }

    public function login(Request $request) {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = auth('api')->attempt($credentials);

        return $this->respondWithToken($token, auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

     // Helper method
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }
}
