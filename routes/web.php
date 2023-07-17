<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;

Route::get('/', [RecipeController::class, 'index']);

Route::get('/recipes', [RecipeController::class, 'index']);

Route::get('/recipes/create', [RecipeController::class, 'create']);

Route::get('/recipes/{recipe}', [RecipeController::class ,'show']);

