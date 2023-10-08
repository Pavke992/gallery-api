<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorsGalleriesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\MyGalleriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth::sanctum')->prefix('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::apiResource('/galleries', GalleriesController::class);
Route::get('/my-galleries/{page?}/{term?}', [MyGalleriesController::class, 'index']);
Route::get('authors-galleries/{id}/{page?}/{term?}', [AuthorsGalleriesController::class, 'index']);
Route::apiResource('galleries.comments', CommentsController::class)->only(['store', 'destroy']);
