<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\UserController;
use \App\Http\Controllers\Api\TransactionController;





// Alterações dos Usuários Loja/ Usuário comum
Route::get('/user', [\App\Http\Controllers\Api\UserController::class,'index']);
Route::post('/user', [\App\Http\Controllers\Api\UserController::class,'store']);
Route::get('/user/{id}', [\App\Http\Controllers\Api\UserController::class,'show']);
Route::put('/user/{id}', [\App\Http\Controllers\Api\UserController::class,'update']);
Route::delete('/user/{id}', [\App\Http\Controllers\Api\UserController::class,'destroy']);



// Transaction
Route::get('/transaction', [\App\Http\Controllers\Api\TransactionController::class,'index']);
Route::post('/transaction', [\App\Http\Controllers\Api\TransactionController::class,'store']);
Route::get('/transaction/{id}', [\App\Http\Controllers\Api\TransactionController::class,'show']);
