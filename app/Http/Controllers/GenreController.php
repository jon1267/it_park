<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Requests\StoreGenreRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class GenreController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('front.genre.index')->with(['genres' => Genre::all()]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('front.genre.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenreRequest $request): JsonResponse
    {
        Genre::create($request->validated());

        return response()->json(['message' => 'Новый жанр создан']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * @param Genre $genre
     *
     * @return View
     */
    public function edit(Genre $genre): View
    {
        return view('front.genre.update')->with(['genre' => $genre]);
    }

    /**
     * @param StoreGenreRequest $request
     * @param Genre $genre
     *
     * @return JsonResponse
     */
    public function update(StoreGenreRequest $request, Genre $genre): JsonResponse
    {
        $genre->update($request->validated());

        return response()->json(['message' => 'Жанр обновлен']);
    }

    /**
     * @param Genre $genre
     *
     * @return JsonResponse
     */
    public function destroy(Genre $genre): JsonResponse
    {
        $genre->delete();

        return response()->noContent();
    }
}
