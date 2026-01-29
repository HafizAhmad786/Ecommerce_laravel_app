<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function loginPage()
    {
        return view("auth.login");
    }

    public function registerPage()
    {
        return view("auth.register");
    }

    public function getUserInfo()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function updateUserInfor(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:100',
        ]);

        User::where("id",  $validated['user_id'])->update([
            "name" => $request->name,
        ]);
        return redirect()->route("getUserInfo")->with('success', 'Profile updated!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route("dashboard");
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:100",
            'email' => 'required|string|email|unique:users,email',
            "password" => "required|string|min:6",
        ]);

        $user = User::create([
            "name" => $validated['name'],
            "email" => $validated['email'],
            "password" => Hash::make($validated['password']),
            "role" => $request->role,
        ]);

        Auth::login($user);

        return redirect()->route("loginPage");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route("loginPage");
    }
}
