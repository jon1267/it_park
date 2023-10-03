<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiGenreController;
use App\Http\Controllers\Api\ApiFilmController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/genres', [ApiGenreController::class, 'genres']);
Route::get('/genre/{id}/films', [ApiGenreController::class, 'genreFilms']);

Route::get('/films', [ApiFilmController::class, 'allFilms']);
Route::get('/film/{id}', [ApiFilmController::class, 'oneFilm']);