<?php

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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieReviewController;

Route::get('/docs', function () {
    return view('swagger');
});

Route::get('/hello', function () {
    return Response::json([
        "message" => "Hello from Sriflix API"
    ]);
});

Route::prefix("movies")->group(function () {
    Route::get("/", [MovieController::class, "get_all"]);
    Route::get("/{id}", [MovieController::class, "get_by_id"]);
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/me', [AuthController::class, 'get_me'])->middleware('auth:sanctum');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::prefix('reviews')->group(function () {
    Route::post("/{movieId}", [MovieReviewController::class, 'create'])->middleware('auth:sanctum');
    Route::get('/{movieId}', [MovieReviewController::class, 'get_by_movie']);
});
