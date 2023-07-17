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

Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

    //candidates
    Route::apiResource('candidates', App\Http\Controllers\Api\CandidateController::class);

    //candidates
    Route::apiResource('votings', App\Http\Controllers\Api\VotingController::class);
    Route::delete('votings/delete/all', [App\Http\Controllers\Api\VotingController::class, 'clear']);
});



