<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $credentials = $request->only("email", "password");
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                "status" => 200,
                "message" => "User LoggedIn successfully",
                "token" => $user->createToken('auth_token')->plainTextToken
            ]);
        }

        return response()->json([
            "status" => 401,
            "message" => "The provided credentials do not match our records.",
        ],401); // for error 
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => $request->role,
        ]);


        return response()->json([
            "status" => 201,
            "message" => "User created successfully",
            "token" => $user->createToken('auth_token')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "status" => 200,
            "message" => "User logged out successfully"
        ]);
    }

    public function updateUserInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 422, // Or 422 for validation errors
                "message" => "Validation Error",
                "errors" => $validator->errors() // Or customize this further
            ], 422);
        }

        Auth::user()->update([
            "name" => $request->name,
        ]);
        return response()->json([
            "statis" => true,
            'message' => 'Profile updated successfully',
        ]);
    }

    public function getUserInfo()
    {
        return response()->json([
            "status" => true,
            "user" => Auth::user()
        ]);
    }
}
