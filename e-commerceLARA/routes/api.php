<?php

use App\Http\Controllers\OrderController;

use App\Http\Controllers\ShoppingCardController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsersController;
use App\Models\ShoppingCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});



Route::post("createorder/{id}", [OrderController::class,'create']);
Route::delete("delete/{id}", [OrderController::class,'destroy']);
Route::get("getorders", [OrderController::class,'show']);

Route::get("/products", [ProductController::class, 'index']);
Route::post("/getproduct/{id}", [ProductController::class, 'show']);
Route::post("/insertproduct", [ProductController::class, 'create']);
Route::put('/updateproduct/{id}/', [ProductController::class,'update']);
Route::delete('/deleteproduct/{id}/', [ProductController::class,'delete']);


Route::post("/orderhistory", [OrderHistoryController::class,'create']);
Route::post("/getorderhistory", [OrderHistoryController::class,'show']);

Route::post("/addtocart", [ShoppingCardController::class,'store']);
Route::delete("/deletecart", [ShoppingCardController::class,'destroy']);
Route::get("/getcart", [ShoppingCardController::class,'show']);