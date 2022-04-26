<?php

use App\Http\Controllers\AttemptController;
use App\Http\Controllers\CurrentGameController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GuessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('games')->group(function() {
    Route::post('', [GameController::class, 'store'])->name('games.store');
    Route::get('current', CurrentGameController::class)->name('games.current');

    Route::prefix('{game}/attempts')->group(function() {
        Route::post('', [AttemptController::class, 'store'])->name('attempts.store');

        Route::prefix('attempts/{attempt}')->group(function() {
            Route::post('guesses', [GuessController::class, 'store'])->name('guesses.store');
        });
    }) ;
});


Route::middleware('auth')->group(function() {
    Route::apiResource('games', GameController::class)->except('store');
});
