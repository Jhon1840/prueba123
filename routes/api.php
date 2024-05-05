<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\userController;
use App\Http\Controllers\Api\loginController;
use App\Http\Controllers\Api\Procedimientos;

//Manejo de Usuarios
    
    Route::post('/usuarios', [UserController::class, 'store']);
    Route::get('/usuarios', [UserController::class, 'index']);
    Route::get('/usuarios/{id}', [UserController::class, 'show']);
    Route::put('/usuarios/{id}', [UserController::class, 'update']); 
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);
    Route::post('/logout', [UserController::class, 'logout']);

//Manejo de Garaje, Vehiculo, Seecion

Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/postvehiculos', [Procedimientos::class, 'storeVehiculo']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/getvehiculos', [Procedimientos::class, 'show']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/garajes', [Procedimientos::class, 'storeGaraje']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/getGarajes', [Procedimientos::class, 'showGaraje']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/showUser', [Procedimientos::class, 'showUser']);
});


