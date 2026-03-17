<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    return $request->contributors();
});
Route::post('/register', [AuthController::class, 'register']);
 Route::post('/login', [AuthController::class, 'login']);   