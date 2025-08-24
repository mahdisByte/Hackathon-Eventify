<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserAuthController extends Controller
{
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Invalid credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Could not create token'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => auth()->user(),
            'msg' => 'User login successful'
        ]);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);

        $user = User::create($input);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
            'msg' => 'User register successful'
        ]);
    }


    public function logout(Request $request)
{
    try {
        auth()->logout(); 
        return response()->json([
            'success' => true,
            'msg' => 'User logged out successfully'
        ]);
    } catch (JWTException $e) {
        return response()->json([
            'success' => false,
            'msg' => 'Failed to logout, token invalid'
        ], 400);
    }
}

    
    public function me(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json($user);
        } catch (JWTException $e) {
            return response()->json(['msg' => 'Token invalid or expired'], 401);
        }
    }


    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json(['token' => $newToken]);
        } catch (JWTException $e) {
            return response()->json(['msg' => 'Token refresh failed'], 401);
        }
    }
}
