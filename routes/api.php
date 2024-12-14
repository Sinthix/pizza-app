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
    Route::get('/pizzas', [PizzaController::class, 'index'])->name('pizzas.index');
    Route::post('/pizzas', [PizzaController::class, 'store'])->name('pizzas.store');
    Route::get('/pizzas/{id}', [PizzaController::class, 'show'])->name('pizzas.show');
    Route::put('/pizzas/{id}', [PizzaController::class, 'update'])->name('pizzas.update');
    Route::delete('/pizzas/{id}', [PizzaController::class, 'destroy'])->name('pizzas.destroy');
    Route::post('/pizzas/random', [PizzaController::class, 'generateRandomPizza'])->name('pizzas.random');
    Route::put('/pizzas/{id}/image', [PizzaController::class, 'updateImage'])->name('pizzas.updateImage');
    
    Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
    Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::get('/ingredients/{id}', [IngredientController::class, 'show'])->name('ingredients.show');
    Route::put('/ingredients/{id}', [IngredientController::class, 'update'])->name('ingredients.update');
    Route::delete('/ingredients/{id}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');
    Route::put('/ingredients/{id}/image', [IngredientController::class, 'updateImage'])->name('ingredients.updateImage');
});


Route::middleware('auth:sanctum')->get('management', [AuthController::class, 'management']);