<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;

Route::get('/', [RecipeController::class, 'index']);

Route::get('/recipes', [RecipeController::class, 'index']);

Route::get('/recipes/create', [RecipeController::class, 'create']);

Route::get('/recipes/{recipe}', [RecipeController::class ,'show']);

Route::post('/recipes', [RecipeController::class, 'store']);

Route::delete('/recipes/{recipe}',[RecipeController::class,'destroy']);

Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit']);
Route::put('/recipes/{recipe}', [RecipeController::class, 'update']);