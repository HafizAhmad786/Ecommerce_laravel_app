<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    CartController,
    ProductController,
    SalesController
};

Route::get("/user/profile", [AuthController::class, "getUserInfo"])->middleware('auth:sanctum');
Route::post("/user/updateProfile", [AuthController::class, "updateUserInfo"])->middleware('auth:sanctum');

// Auth
Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);
Route::post("/logout", [AuthController::class, "logout"])->middleware('auth:sanctum');

//cart
Route::middleware("auth:sanctum")->group(function () {
    Route::get("/cart", [CartController::class, "index"]);
    Route::get("/getCartProducts", [CartController::class, "getCartProducts"]);
    Route::post("/addToCart", [CartController::class, "addToCart"]);
    Route::post("/initializePayment", [CartController::class, "initializePayment"]);
    Route::post("/makePayment", [CartController::class, "makePayment"]);
});

// product routes
Route::middleware(['auth:sanctum', 'role:seller'])->group(function () {
    Route::post("/product/create", [ProductController::class, "createProduct"]);
    Route::post("/product/update", [ProductController::class, "updateProduct"]);
    Route::get("/product/delete/{id}", [ProductController::class, "deleteProduct"]);
    Route::get("/product/{id}", [ProductController::class, "getProductById"]);
    Route::get("/products", [ProductController::class, "index"]);
    Route::post("/searchProducts",[ProductController::class,"searchProducts"]);
});

Route::get("/user/sales", [SalesController::class, "index"])->middleware('auth:sanctum');
Route::post("/getProduct", [SalesController::class, "getOrderProducts"])->middleware('auth:sanctum');
