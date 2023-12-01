<?php

// php artisan test --filter=PestTest

use App\Models\Genre;
use App\Models\User;

beforeEach(function () {
    $this->user = \App\Models\User::factory()->create(); // creat new User before each test
});

it('unauthenticated user cannot see janrs page', function () {
    $this->get('/janrs')
        ->assertStatus(302)
        ->assertRedirect('login');
});

it('janrs page contains empty table', function () {
    $this->actingAs($this->user)
        ->get('/janrs')
        ->assertStatus(200)
        ->assertSee('жанры не найдены');
});

it('janrs page contains non empty table', function () {
    $janr = Genre::create(['name' => 'медодрама-сериал']);

    $this->actingAs($this->user)
        ->get('/janrs')
        ->assertStatus(200)
        ->assertDontSee('жанры не найдены')
        ->assertSee('медодрама-сериал')
        ->assertViewHas('genres', function ($collection) use ($janr) {
        return $collection->contains($janr);
    });
});

it('create janr is successful', function () {
    $janr = ['name' => 'медодрама-сериал'];

    $response = $this->actingAs($this->user)->post('/janrs', $janr);
    $lastRecord = Genre::latest()->first();

    $response->assertStatus(200);
    $this->assertDatabaseHas('genres', $janr);

    expect('Новый жанр создан')->toBe($response['message']) ;
    expect($janr['name'])->toBe($lastRecord->name);
});

it('success login redirect to dashboard page', function () {
    User::create([
        'name' => 'Test',
        'email' => 'test@test.com',
        'password' => bcrypt('password123')
    ]);

    $this->post('/login', ['email' => 'test@test.com', 'password' => 'password123'])
        ->assertStatus(302)
        ->assertRedirect('dashboard');
});