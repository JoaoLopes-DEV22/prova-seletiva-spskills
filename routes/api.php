<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProvaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rota responsável por registrar usuário
Route::post('/registro', [UserController::class, 'store']);

// Rota responsável por autenticar o usuário
Route::post('/login', [AuthController::class, 'auth']);

// Rota responsável por deslogar o usuário
Route::get('/logout', [AuthController::class, 'logout']);

// Rota responsável criar prova
Route::post('/prova', [ProvaController::class, 'store']);

// Rota responsável por alterar o status da prova 
Route::post('/prova/{id}/finalizar', [ProvaController::class, 'updateStatus']);

// Rota responsável por selecionar a prova pelo id
Route::post('/prova/{id}', [ProvaController::class, 'showById']);
