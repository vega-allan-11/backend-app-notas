<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;

// 📁 Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// 📁 Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/notes',              [NoteController::class, 'index']);
    Route::post('/notes',             [NoteController::class, 'store']);
    Route::get('/notes/{id}',         [NoteController::class, 'show']);
    Route::put('/notes/{id}',         [NoteController::class, 'update']);
    Route::delete('/notes/{id}',      [NoteController::class, 'destroy']);
    Route::get('/notes/search/{text}',[NoteController::class, 'search']);
    Route::get('/notes/order/{by}',   [NoteController::class, 'order']);
    Route::patch('/notes/{id}/favorite', [NoteController::class, 'toggleFavorite']);


    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    Route::get('/user/profile', [AuthController::class, 'getProfile']);
});
