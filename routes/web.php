<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get("/user/profile", [AuthController::class, "getUserInfo"])->name("getUserInfo")->middleware('auth');
Route::post("/user/profile/update", [AuthController::class, "updateUserInfor"])->name("updateUserInfor")->middleware('auth');
//for view
Route::get("/login", [AuthController::class, "loginPage"])->name("loginPage");
Route::get("/register", [AuthController::class, "registerPage"])->name("registerPage");

Route::get("/seller/dashboard", [ProductController::class, "getAllProducts"])->name("sellerdashboard")->middleware(['auth', 'role:seller']);
Route::get("/buyer/dashboard", [ProductController::class, "getAllProducts"])->name("buyerdashboard")->middleware(['auth', 'role:buyer']);

// for logic
Route::post("/login", [AuthController::class, "login"])->name("login");
Route::post("/register", [AuthController::class, "register"])->name("register");

Route::get("/logout", [AuthController::class, "logout"])->name("logout");

//product routes

Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::post("/product/create", [ProductController::class, "createProduct"])->name("createProduct");
    Route::post("/product/update", [ProductController::class, "updateProduct"])->name("updateProduct");
    Route::get("/product/delete/{id}", [ProductController::class, "deleteProduct"])->name("deleteProduct");
    Route::get("/product/get", [ProductController::class, "getProductById"])->name("getProductById");
});