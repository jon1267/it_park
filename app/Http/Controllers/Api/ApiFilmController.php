<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Film;
use App\Http\Resources\Film as FilmResource;

class ApiFilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function allFilms()
    {
        $films = Film::with('genres')->paginate(5);

        return FilmResource::collection($films);
    }

    /**
     * Display the specified resource.
     */
    public function oneFilm(string $id)
    {
        return FilmResource::collection(
            Film::with('genres')->where('id', $id)->get()
        );
    }


}
