<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorsGalleriesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\GalleriesController;
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



Route::get('/all-galleries/{page}/{term}', [GalleriesController::class, 'index']);
Route::post('/galleries', [GalleriesController::class, 'store']);
Route::get('/galleries/{id}', [GalleriesController::class, 'show']);
Route::put('/galleries/{id}', [GalleriesController::class, 'update']);
Route::delete('/galleries/{id}', [GalleriesController::class, 'destroy']);
Route::get('/my-galleries/{page}/{term?}', [MyGalleriesController::class, 'index']);
Route::get('/authors-galleries/{id}/{page}/{term?}', [AuthorsGalleriesController::class, 'index']);
Route::post('/galleries/{id}/comments', [CommentsController::class, 'store']);
Route::delete('/comments/{id}', [CommentsController::class, 'destroy']);
