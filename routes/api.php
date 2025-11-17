<?php

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
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\PhotoApiController as ApiPhoto;
use App\Http\Controllers\Api\PhotoApiController;
use App\Http\Controllers\Api\ChatApiController;

Route::post('/chat', [ChatApiController::class, 'chat']);





Route::get('/photos', [PhotoApiController::class, 'index']);
Route::post('/photos', [PhotoApiController::class, 'store']);
Route::get('/photos/{id}', [PhotoApiController::class, 'show']);
Route::put('/photos/{id}', [PhotoApiController::class, 'update']);
Route::delete('/photos/{id}', [PhotoApiController::class, 'destroy']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/photos', [ApiPhoto::class, 'index']);
    Route::post('/photos', [ApiPhoto::class, 'store']);
    Route::delete('/photos/{id}', [ApiPhoto::class, 'destroy']);
});


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());
