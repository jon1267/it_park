<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use App\Services\Films\FilmService;
use App\Services\Image\Img;
use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;

class FilmController extends Controller
{
    private FilmService $filmService;
    private Img $img;

    public function __construct(FilmService $filmService, Img $img)
    {
        $this->filmService = $filmService;
        $this->img = $img;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = Film::with('genres')
            ->where('status', '=' ,1)
            ->paginate(15);

        return view('front.film.index')->with(['films' => $films]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('front.film.create')->with(['genres' => Genre::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmRequest $request)
    {
        $result = $this->filmService->createFilm($request);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        return view('front.film.update')->with([
            'film'   => $film,
            'genres' => Genre::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmRequest $request, Film $film)
    {
        $result = $this->filmService->updateFilm($request, $film);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        $result = $this->filmService->deleteFilm($film);

        return response()->json($result);
    }

    public function publish(Film $film)
    {
        $this->filmService->publish($film);

        return response()->json(['message' => 'Film published']);
    }

    public function unPublish(Film $film)
    {
        $this->filmService->unPublish($film);

        return response()->json(['message' => 'Film unpublished']);
    }
}
