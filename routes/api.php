<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\IngredientController;


Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pizzas', [PizzaController::class, 'index']);
    Route::post('/pizzas', [PizzaController::class, 'store']); 
    Route::get('/pizzas/{id}', [PizzaController::class, 'show']); 
    Route::put('/pizzas/{id}', [PizzaController::class, 'update']); 
    Route::delete('/pizzas/{id}', [PizzaController::class, 'destroy']);
    Route::post('/pizzas/random', [PizzaController::class, 'generateRandomPizza']);
    Route::put('/pizzas/{id}/image', [PizzaController::class, 'updateImage']);
    
    Route::get('/ingredients', [IngredientController::class, 'index']);
    Route::post('/ingredients', [IngredientController::class, 'store']); 
    Route::get('/ingredients/{id}', [IngredientController::class, 'show']);
    Route::put('/ingredients/{id}', [IngredientController::class, 'update']);
    Route::delete('/ingredients/{id}', [IngredientController::class, 'destroy']);
    Route::put('/ingredients/{id}/image', [IngredientController::class, 'updateImage']); 
    
});

Route::middleware('auth:sanctum')->get('management', [AuthController::class, 'management']);