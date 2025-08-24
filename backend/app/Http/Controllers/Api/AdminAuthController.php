<?php

/*
Admin login credentials:
mahdikhan.chowdhury@gmail.com
admin123
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AdminAuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'msg' => 'Invalid credentials'
            ], 401);
        }

        $token = JWTAuth::fromUser($admin);

        return response()->json([
            'success' => true,
            'token' => $token,
            'admin' => $admin,
            'msg' => 'Admin login successful',
            'redirect' => '/homepage'
        ]);
    }

    public function logout(Request $request)
    {
        try {
            // Invalidate the token sent in Authorization header
            JWTAuth::parseToken()->invalidate();

            return response()->json([
                'success' => true,
                'msg' => 'Admin logged out successfully'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Failed to logout'
            ], 400);
        }
    }
}
