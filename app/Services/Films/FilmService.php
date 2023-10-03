<?php

namespace App\Services\Films;

use App\Models\Film;
use App\Services\Image\Img;
use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;

class FilmService
{
    const STATUS_UNPUBLISHED  = 0;
    const STATUS_PUBLISHED    = 1;

    private Img $img;

    public function __construct(Img $img)
    {
        $this->img = $img;
    }

    public function publish(Film $film): void
    {
        $film->update(['status' => self::STATUS_PUBLISHED ]);
    }

    public function unPublish(Film $film): void
    {
        $film->update(['status' => self::STATUS_UNPUBLISHED]);
    }

    public function createFilm(StoreFilmRequest $request): array
    {
        try {
            $data = $request->except('_token', 'genres'); // genres - жанры
            $data['poster'] = $request->hasFile('poster') ? $this->img->getPoster($request) : 'img/default.jpg';

            $film = Film::create($data);
            $film->genres()->attach($request->genres);

            $result = ['message' => 'Film created'];
        } catch (\Exception $e) {
            $result = ['message' => 'Film creation error. ' . $e->getMessage()];
        }

        return $result;
    }

    public function updateFilm(UpdateFilmRequest $request, Film $film): array
    {
        try {
            $data = $request->except('_token', '_method', 'genres');
            $data['poster'] = $request->hasFile('poster') ? $this->img->updatePoster($request, $film) : $film->poster;

            $film->update($data);
            if(is_array($request->genres) && count($request->genres)) {
                $film->genres()->sync($request->genres);
            }

            return ['message' => 'Film was updated'];
        } catch (\Exception $e) {
            return ['message' => 'Film update error. ' . $e->getMessage()];
        }
    }

    public function deleteFilm(Film $film): array
    {
        try {
            $film->genres()->detach();
            if(file_exists($film->poster)) {
                unlink($film->poster);
            }
            $film->delete();
            return ['message' => 'Film was deleted'];
        } catch (\Exception $e) {
            return ['message' => 'Film not deleted. Error. ' . $e->getMessage()];
        }
    }
}