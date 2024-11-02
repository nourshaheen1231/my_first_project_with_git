<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('/profile', [AuthController::class, 'userProfile'])->middleware('auth:api');
});


 Route::get('posts',[PostController::class,'index']);
 Route::get('post/{id}',[PostController::class,'show']);
 Route::post('post',[PostController::class,'store']);
 Route::post('post/{id}',[PostController::class,'update']);
 Route::post('delete_post/{id}',[PostController::class,'destroy']);
