<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Requests\StoreGenreRequest;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('front.genre.index')->with(['genres' => Genre::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('front.genre.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenreRequest $request)
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
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('front.genre.update')->with(['genre' => $genre]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreGenreRequest $request, Genre $genre)
    {
        $genre->update($request->validated());

        return response()->json(['message' => 'Жанр обновлен']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return response()->noContent();
    }
}
