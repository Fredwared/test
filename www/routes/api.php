<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::get('me', [UserController::class, 'me'])
    ->middleware('auth:sanctum')
    ->name('me');

Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['auth:sanctum', 'admin']], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('{user}', [UserController::class, 'show'])->name('show');
    Route::patch('{user}', [UserController::class, 'update'])->name('update');
    Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
});
