<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Http\Resources\Genre as GenreResource;
use App\Http\Resources\Film as FilmResource;

class ApiGenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function genres()
    {
        return GenreResource::collection(Genre::all());
    }


    /**
     * Display the specified resource.
     */
    public function genreFilms(string $id)
    {
        $genre = Genre::findOrFail($id);
        $films = $genre->films()->paginate(5); //знаю, что так просто paginate(5) плохо. в конфиг. или еще куда.

        return FilmResource::collection($films);
    }

}
