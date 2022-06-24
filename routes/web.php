<?php

use App\Http\Controllers\AttemptController;
use App\Http\Controllers\AttemptGuessController;
use App\Http\Controllers\CurrentGameController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GuessController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayerCurrentAttemptController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

Route::post('players', [PlayerController::class, 'store'])->name('players.store');

Route::prefix('players/{player}')->group(function() {
    Route::get('/', [PlayerController::class, 'show'])->name('players.show');
    Route::post('/attempts', [AttemptController::class, 'store'])->name('attempts.store');
    Route::get('/attempts/current', PlayerCurrentAttemptController::class)->name('attempts.current');

    Route::prefix('/attempts/{attempt}')->group(function() {
        Route::get('/guesses', [AttemptGuessController::class, 'index'])->name('attempts.guesses.index');
        Route::post('/guesses', [GuessController::class, 'store'])->name('guesses.store');
    });
});

Route::get('/games/current', CurrentGameController::class)->name('games.current');

Route::middleware('auth')->group(function() {
    Route::prefix('games')->group(function() {
        Route::get('/submitted', [GameController::class, 'submitted'])->name('games.submitted');
        Route::get('/queued', [GameController::class, 'queued'])->name('games.queued');
        Route::get('/finished', [GameController::class, 'finished'])->name('games.finished');
    });
    Route::apiResource('games', GameController::class);
});
