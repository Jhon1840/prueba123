<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\userController;
use App\Http\Controllers\Api\loginController;

    Route::post('/login', [UserController::class, 'login']);

    Route::post('/usuarios', [UserController::class, 'store']);
    Route::get('/usuarios', [UserController::class, 'index']);
    Route::get('/usuarios/{id}', [UserController::class, 'show']);
    Route::put('/usuarios/{id}', [UserController::class, 'update']); // asumiendo que tienes un método 'update'
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);

