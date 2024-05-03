<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\userController;

Route::get('/usuarios', [userController::class, 'index']);


Route::get('/usuarios/{id}', [userController::class, 'show']);


Route::post('/usuarios',[userController::class,'store']);


Route::put('/usuarios/{id}',function(){
    return 'Actualizando usuario';
});

Route::delete('/usuarios/{id}',[userController::class ,'destroy']);