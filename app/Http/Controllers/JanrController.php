<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Requests\StoreGenreRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class JanrController extends Controller
{
    public function index(): View
    {
        return view('front.genre.index')->with(['genres' => Genre::paginate(10)]);
    }

    public function create(): View
    {
        return view('front.genre.create');
    }

    public function store(StoreGenreRequest $request): JsonResponse
    {
        Genre::create($request->validated());

        return response()->json(['message' => 'Новый жанр создан']);
    }

    public function show(Genre $janr): JsonResponse
    {
        return response()->json($janr);
    }

    public function edit(Genre $janr): View
    {
        return view('front.genre.update')->with(['genre' => $janr]);
    }

    public function update(StoreGenreRequest $request, Genre $janr): JsonResponse
    {
        $janr->update($request->validated());

        return response()->json(['message' => 'Жанр обновлен']);
    }

    public function destroy(Genre $janr): JsonResponse
    {
        $janr->delete();

        return response()->json(['message' => 'Жанр удален']); //response()->noContent();
    }
}
