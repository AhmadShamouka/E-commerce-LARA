<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsersController;
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

Route::post("/products/{id}", [ProductController::class, 'index']);
Route::post("/getproduct/{id}", [ProductController::class, 'show']);
Route::post("/insertproduct", [ProductController::class, 'create']);
Route::put('/updateproduct/{id}/', [ProductController::class,'update']);
Route::delete('/deleteproduct/{id}/', [ProductController::class,'delete']);


Route::post("/setOrderhistory", [OrderHistoryController::class,'create']);
Route::post("/getOrderhistory", [OrderHistoryController::class,'show']);