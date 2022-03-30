<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

// Auth Routes--------------------
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'postRegister']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('recipes', RecipeController::class);

    Route::get('/recipes/{userId}/index', [RecipeController::class, 'recipeUserIndex']);
    Route::get('/recipes/category/likes', [RecipeController::class, 'recipeLikes']);
    Route::get('/recipes/category/{category}', [RecipeController::class, 'recipesCategoryIndex']);
    Route::post('/recipes/{recipeId}/comment', [RecipeController::class, 'recipeComment']);

    Route::post('recipes/{recipeId}/vote', [RatingController::class, 'vote']);
});


Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/', [RecipeController::class, 'index']);
