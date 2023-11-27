<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('films',FilmController::class )->except('show');
Route::resource('genres', GenreController::class );//->except('show');

Route::get('films/{film}/publish', [FilmController::class, 'publish']);
Route::get('films/{film}/unpublish', [FilmController::class, 'unPublish']);