<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('auth.login');
});

//for view
Route::get("/login", [AuthController::class, "loginPage"])->name("loginPage");
Route::get("/register", [AuthController::class, "registerPage"])->name("registerPage");

Route::get("/seller/dashboard", function () {
    return view('seller.dashboard');
})->name("sellerdashboard")->middleware(['auth','role:seller']);

Route::get("/buyer/dashboard", function () {
    return view('buyer.dashboard');
})->name("buyerdashboard")->middleware(['auth','role:buyer']);


// for logic
Route::post("/login", [AuthController::class, "login"])->name("login");
Route::post("/register", [AuthController::class, "register"])->name("register");
