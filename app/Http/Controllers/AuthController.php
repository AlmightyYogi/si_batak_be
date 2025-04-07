<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|min:6|max:100',
            'username' => 'required|string|min:6|max:50',
            'password' => 'required|min:6|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    public function login (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:6|max:50',
            'password' => 'required|string|min:6|max:60',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Password',
            ], 401);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ], 200);
    }

    public function profile()
    {
        return response()->json(auth()->user(), 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
}
