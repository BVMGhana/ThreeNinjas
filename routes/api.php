<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ButtonController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\WhiteNinjaController;
use App\Http\Controllers\BlackNinjaController;
use App\Http\Controllers\RedNinjaController;
use App\Http\Controllers\PreviousResultController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BetcodeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users-count', [UserController::class, 'count']);
Route::get('/predictions-count', [UserController::class, 'count_all']);
Route::get('/recent-users', [UserController::class, 'recent']);

Route::get('/buttons', [ButtonController::class, 'index']);
Route::post('/buttons', [ButtonController::class, 'store']);
Route::get('/buttons/{id}', [ButtonController::class, 'show']);
Route::put('/buttons/{id}', [ButtonController::class, 'update']);
Route::delete('/buttons/{id}', [ButtonController::class, 'destroy']);

Route::get('/leagues', [LeagueController::class, 'index']);
Route::post('/leagues', [LeagueController::class, 'store']);
Route::get('/leagues/{id}', [LeagueController::class, 'show']);
Route::put('/leagues/{id}', [LeagueController::class, 'update']);
Route::delete('/leagues/{id}', [LeagueController::class, 'destroy']);

Route::get('/fixtures', [FixtureController::class, 'index']);
Route::post('/fixtures', [FixtureController::class, 'store']);
Route::get('/fixtures/{id}', [FixtureController::class, 'show']);
Route::put('/fixtures/{id}', [FixtureController::class, 'update']);
Route::delete('/fixtures/{id}', [FixtureController::class, 'destroy']);

Route::get('/tips', [TipController::class, 'index']);
Route::post('/tips', [TipController::class, 'store']);
Route::get('/tips/{id}', [TipController::class, 'show']);
Route::put('/tips/{id}', [TipController::class, 'update']);
Route::delete('/tips/{id}', [TipController::class, 'destroy']);

Route::get('/banners', [BannerController::class, 'index']);
Route::post('/banners', [BannerController::class, 'store']);
Route::get('/banners/{id}', [BannerController::class, 'show']);
Route::put('/banners/{id}', [BannerController::class, 'update']);
Route::delete('/banners/{id}', [BannerController::class, 'destroy']);

Route::get('/white-ninjas', [WhiteNinjaController::class, 'index']);
Route::post('/white-ninjas', [WhiteNinjaController::class, 'store'])->name('white-ninja');
Route::get('/white-ninjas/{id}', [WhiteNinjaController::class, 'show']);
Route::put('/white-ninjas/{id}', [WhiteNinjaController::class, 'update']);
Route::delete('/white-ninjas/{id}', [WhiteNinjaController::class, 'destroy']);

Route::get('/red-ninjas', [RedNinjaController::class, 'index']);
Route::post('/red-ninjas', [RedNinjaController::class, 'store']);
Route::get('/red-ninjas/{id}', [RedNinjaController::class, 'show']);
Route::put('/red-ninjas/{id}', [RedNinjaController::class, 'update']);
Route::delete('/red-ninjas/{id}', [RedNinjaController::class, 'destroy']);


Route::get('/black-ninjas', [BlackNinjaController::class, 'index']);
Route::post('/black-ninjas', [BlackNinjaController::class, 'store']);
Route::get('/black-ninjas/{id}', [BlackNinjaController::class, 'show']);
Route::put('/black-ninjas/{id}', [BlackNinjaController::class, 'update']);
Route::delete('/black-ninjas/{id}', [BlackNinjaController::class, 'destroy']);

Route::get('/previous-results', [PreviousResultController::class, 'index']);
Route::post('/previous-results', [PreviousResultController::class, 'store']);
Route::get('/previous-results/{id}', [PreviousResultController::class, 'show']);
Route::put('/previous-results/{id}', [PreviousResultController::class, 'update']);
Route::delete('/previous-results/{id}', [PreviousResultController::class, 'destroy']);

Route::get('/betcodes', [BetcodeController::class, 'index']);
Route::post('/betcodes', [BetcodeController::class, 'store']);
Route::get('/betcodes/{id}', [BetcodeController::class, 'show']);
Route::put('/betcodes/{id}', [BetcodeController::class, 'update']);
Route::delete('/betcodes/{id}', [BetcodeController::class, 'destroy']);