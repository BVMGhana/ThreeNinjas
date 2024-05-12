<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\WhiteNinjaController;
use App\Http\Controllers\BlackNinjaController;
use App\Http\Controllers\RedNinjaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/leagues', [LeagueController::class, 'index']);
Route::post('/leagues', [LeagueController::class, 'store']);
Route::get('/leagues/{id}', [LeagueController::class, 'show']);
Route::delete('/leagues/{id}', [LeagueController::class, 'destroy']);
Route::put('/leagues/{id}', [LeagueController::class, 'update']);

Route::get('/fixtures', [FixtureController::class, 'index']);
Route::post('/fixtures', [FixtureController::class, 'store']);
Route::get('/fixtures/{id}', [FixtureController::class, 'show']);
Route::delete('/fixtures/{id}', [FixtureController::class, 'destroy']);
Route::put('/fixtures/{id}', [FixtureController::class, 'update']);

Route::get('/tips', [TipController::class, 'index']);
Route::post('/tips', [TipController::class, 'store']);
Route::get('/tips/{id}', [TipController::class, 'show']);
Route::delete('/tips/{id}', [TipController::class, 'destroy']);
Route::put('/tips/{id}', [TipController::class, 'update']);

Route::get('/banners', [BannerController::class, 'index']);
Route::post('/banners', [BannerController::class, 'store']);
Route::get('/banners/{id}', [BannerController::class, 'show']);
Route::delete('/banners/{id}', [BannerController::class, 'destroy']);
Route::put('/banners/{id}', [BannerController::class, 'update']);

Route::get('/white-ninjas', [WhiteNinjaController::class, 'index']);
Route::post('/white-ninjas', [WhiteNinjaController::class, 'store'])->name('white-ninja');
Route::get('/white-ninjas/{id}', [WhiteNinjaController::class, 'show']);
Route::delete('/white-ninjas/{id}', [WhiteNinjaController::class, 'destroy']);
Route::put('/white-ninjas/{id}', [WhiteNinjaController::class, 'update']);

Route::get('/red-ninjas', [RedNinjaController::class, 'index']);
Route::post('/red-ninjas', [RedNinjaController::class, 'store']);
Route::get('/red-ninjas/{id}', [RedNinjaController::class, 'show']);
Route::delete('/red-ninjas/{id}', [RedNinjaController::class, 'destroy']);
Route::put('/red-ninjas/{id}', [RedNinjaController::class, 'update']);


Route::get('/black-ninjas', [BlackNinjaController::class, 'index']);
Route::post('/black-ninjas', [BlackNinjaController::class, 'store']);
Route::get('/black-ninjas/{id}', [BlackNinjaController::class, 'show']);
Route::delete('/black-ninjas/{id}', [BlackNinjaController::class, 'destroy']);
Route::put('/black-ninjas/{id}', [BlackNinjaController::class, 'update']);