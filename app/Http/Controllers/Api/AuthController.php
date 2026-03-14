<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                "status" => true,
                "token" => $user->createToken('auth_token')->plainTextToken
            ]);
        }

        return response()->json([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:100",
            'email' => 'required|string|email|unique:users,email',
            "password" => "required|string|min:6",
        ]);

        User::create([
            "name" => $validated['name'],
            "email" => $validated['email'],
            "password" => Hash::make($validated['password']),
            "role" => $request->role,
        ]);

        return response()->json([
            "status" => true,
            "message" => "User created successfully"
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }

    public function updateUserInfo(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        User::where("id",  Auth::user()->id)->update([
            "name" => $validated['name'],
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
