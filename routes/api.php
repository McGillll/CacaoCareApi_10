<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CacaoController;
use App\Http\Controllers\UserController;
use AWS\CRT\HTTP\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'authLogin']);
Route::post('auth/register', [AuthController::class, 'register']);


Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('auth/logout', [AuthController::class, 'authLogout']);

    //User
    Route::get('user', [UserController::class, 'getMany']);
    Route::get('user/{user}', [UserController::class, 'getOne']);
    Route::get('current/user', [UserController::class, 'getCurrentUser']);


    //Cacao
    Route::apiResources([
        'cacao' => CacaoController::class
    ]);
});

