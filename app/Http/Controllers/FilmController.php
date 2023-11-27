<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use App\Services\Films\FilmService;
use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class FilmController extends Controller
{
    public function __construct(private FilmService $filmService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('front.film.index')->with([
            'films' => Film::with('genres')
                ->where('status', '=' ,1)
                ->paginate(10),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('front.film.create')->with(['genres' => Genre::all()]);
    }

    /**
     * @param StoreFilmRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreFilmRequest $request): JsonResponse
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
     * @param Film $film
     *
     * @return View
     */
    public function edit(Film $film): View
    {
        return view('front.film.update')->with([
            'film'   => $film,
            'genres' => Genre::all(),
        ]);
    }

    /**
     * @param UpdateFilmRequest $request
     * @param Film $film
     *
     * @return JsonResponse
     */
    public function update(UpdateFilmRequest $request, Film $film): JsonResponse
    {
        $result = $this->filmService->updateFilm($request, $film);

        return response()->json($result);
    }

    /**
     * @param Film $film
     *
     * @return JsonResponse
     */
    public function destroy(Film $film): JsonResponse
    {
        $result = $this->filmService->deleteFilm($film);

        return response()->json($result);
    }

    public function publish(Film $film): JsonResponse
    {
        $this->filmService->publish($film);

        return response()->json(['message' => 'Film published']);
    }

    public function unPublish(Film $film): JsonResponse
    {
        $this->filmService->unPublish($film);

        return response()->json(['message' => 'Film unpublished']);
    }
}
