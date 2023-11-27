<?php

namespace Tests\Feature;

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Film;

class FilmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_films_page_contains_empty_table(): void
    {
        $response = $this->get('/films');

        $response->assertStatus(200);

        $response->assertSee('фильмы не найдены');
    }

    public function test_films_page_contains_non_empty_table(): void
    {
        $film = Film::create([
            'name' => 'Форсаж 2',
            'status' => 1,
            'poster' => 'img/default.jpg'
        ]);

        $response = $this->get('/films');

        $response->assertStatus(200);
        $response->assertDontSee('фильмы не найдены');
        $response->assertSee('Форсаж 2');
        $response->assertViewHas('films', function ($collection) use ($film) {
            return $collection->contains($film);
        });

    }

    public function test_paginated_films_table_doesnt_contain_11th_record(): void
    {
        /*for ($i=1; $i <= 11; $i++) {
            $film = Film::create([
                'name' => 'Film '.$i,
                'status' => 1,
                'poster' => 'img/default.jpg'
            ]);
        } refactor to factory */

        $films = Film::factory(11)->create();
        $lastFilm = $films->last();

        $response = $this->get('/films');

        $response->assertStatus(200);
        $response->assertViewHas('films', function ($collection) use ($lastFilm) {
            return !$collection->contains($lastFilm);
        });

    }

    public function test_api_returns_films_list()
    {
        $film = Film::factory()->create();

        $response = $this->getJson('/api/films');
        $responseFilm = $response['data'][0]; //response()->json($result) return [data {...}]
        $createdFilm = $film->toArray();

        $this->assertEquals($responseFilm['id'], $createdFilm['id']);
        $this->assertEquals($responseFilm['name'], $createdFilm['name']);
        $this->assertEquals($responseFilm['status'], $createdFilm['status']);
    }

    // in Sqlite (i dont now how work code ???) $film->genres()->attach($request->genres);
    public function test_create_genre_of_film_successful()
    {
        $genre = [ 'name' => 'Film Genre 123' ];

        $response = $this->post('/genres', $genre);

        $response->assertStatus(200);
        $this->assertEquals('Новый жанр создан', $response['message']);
        $this->assertDatabaseHas('genres', $genre);

        $lastRecord = Genre::latest()->first();
        $this->assertEquals($genre['name'], $lastRecord->name);
    }

    // edit form
    public function test_genre_edit_contains_correct_values()
    {
        $genre = Genre::factory()->create();
        $lastRecord = Genre::latest()->first();

        $response = $this->get('genres/'.$genre->id .'/edit' );

        $response->assertStatus(200);
        $response->assertSee('value="' .$genre->name.'"', false);
        $response->assertViewHas('genre', $genre );
        $this->assertEquals($genre['name'], $lastRecord->name); //~ may be not so need?
    }

    public function test_genre_update_validation_error_redirect_back_to_form()
    {
        $genre = Genre::factory()->create();

        $response = $this->put('genres/'.$genre->id, ['name' => ''] );

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
        $response->assertInvalid(['name']);
    }

    public function test_genre_delete_successful()
    {
        $genre = Genre::factory()->create();

        $response = $this->delete('genres/' . $genre->id);

        $response->assertStatus(200);
        $this->assertEquals('Жанр удален', $response['message']);
        $this->assertDatabaseMissing('genres', $genre->toArray());
        $this->assertDatabaseCount('genres', 0);
    }

}
