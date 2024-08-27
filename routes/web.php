<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::get('email/verify', [AuthController::class, 'showVerifyEmail'])
    ->middleware('auth')
    ->name('verification.notice'); // <-- don't change the route name


Route::post('/verify-email/request', [AuthController::class, 'request'])
    ->middleware('auth')
    ->name('verification.request');


Route::post('/verify-email/{id}/{hash}', [AuthController::class, 'verify'])
    ->middleware(['auth', 'signed']) // <-- don't remove "signed"
    ->name('verification.verify'); // <-- don't change the route name

// Auth Routes--------------------
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'postRegister']);
Route::get('/forgot-password/{emailToken}', [AuthController::class, 'forgotPasswordWithTokenGet']);
Route::post('/forgot-password/{emailToken}', [AuthController::class, 'forgotPasswordWithToken']);
Route::get('/forgot-password', [AuthController::class, 'forgotPasswordGet']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('recipes', RecipeController::class);
    Route::resource('users', UserController::class);

    Route::get('/recipes/{userId}/index', [RecipeController::class, 'recipeUserIndex']);
    Route::get('/recipes/category/likes', [RecipeController::class, 'recipeLikes']);
    Route::get('/recipes/category/{category}', [RecipeController::class, 'recipesCategoryIndex']);
    Route::post('/recipes/{recipeId}/comment', [RecipeController::class, 'recipeComment']);
    Route::get('/recipes/{commentId}/comment', [RecipeController::class, 'recipeCommentEdit']);
    Route::post('/recipes/{recipeId}/update-comment/{commentId}', [RecipeController::class, 'recipeCommentUpdate']);

    Route::post('recipes/{recipeId}/vote', [RatingController::class, 'vote']);
});



Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/', [RecipeController::class, 'index']);
