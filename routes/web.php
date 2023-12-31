<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Tag;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(RecipeController::class)->middleware(['auth'])->group(function(){
    Route::get('/', [RecipeController::class, 'index'])->name('index');
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::get('/recipes/search', [RecipeController::class, 'search'])->name('recipes.search');
    Route::get('/recipes/{recipe}', [RecipeController::class ,'show'])->name('recipes.show');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::delete('/recipes/{recipe}',[RecipeController::class,'destroy'])->name('recipes.destroy');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::get('/my-recipes', [RecipeController::class, 'myRecipes'])->name('my.recipes');
});

Route::controller(UserController::class)->middleware(['auth'])->group(function(){
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show'); 
});

Route::controller(CategoryController::class)->middleware(['auth'])->group(function(){
    Route::get('/categories/{category}',[CategoryController::class,'index']);
});

Route::controller(TagController::class)->middleware(['auth'])->group(function(){
    Route::get('/tags/{tag}',[TagController::class,'index']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
