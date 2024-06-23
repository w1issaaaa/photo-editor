<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [UserController::class, 'login']);

Route::post('/register', [UserController::class, 'register']);

Route::get('/test', [UserController::class, 'test']);

Route::post('/profile', [UserController::class, 'editUser'])->middleware('auth:sanctum');

Route::get('/profile', [UserController::class, 'showUser'])->middleware('auth:sanctum');

Route::get('/testAuth', [UserController::class, 'testAuth'])->middleware('auth:sanctum');

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/editDescription', [UserController::class, 'editDescription'])->middleware('auth:sanctum');
