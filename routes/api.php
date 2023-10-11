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

use App\Http\Controllers\MovieController;

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
    Route::get("/{id}", [MovieController::class, "get_by_id"])->whereUuid("id");
});
