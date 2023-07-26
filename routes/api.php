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
    
    //Candidates
    Route::apiResource('candidates', App\Http\Controllers\Api\CandidateController::class);

    //Committee
    Route::get('committees', [App\Http\Controllers\Api\CommitteeController::class, 'all_panitia']);
    Route::post('committees', [App\Http\Controllers\Api\CommitteeController::class, 'add_panitia']);

    //Votings
    Route::apiResource('votings', App\Http\Controllers\Api\VotingController::class);
    Route::get('rekap', [App\Http\Controllers\Api\VotingController::class, 'rekap']);
    Route::delete('votings/delete/all', [App\Http\Controllers\Api\VotingController::class, 'clear']);
        
    //Voters
    Route::get('voters', [App\Http\Controllers\Api\VotingController::class, 'all_voter']);
    Route::post('voters', [App\Http\Controllers\Api\VotingController::class, 'add_voter']);
});



