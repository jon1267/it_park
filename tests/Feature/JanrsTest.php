<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Genre;
use App\Models\User;
// php artisan test --filter=JanrsTest

class JanrsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    //setUp() is analog __construct(){} for tests
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_janrs_page_contains_empty_table(): void
    {
        //$user = User::factory()->create();
        $response = $this->actingAs($this->user)->get('/janrs');

        $response->assertStatus(200);

        $response->assertSee('жанры не найдены');
    }

    public function test_janrs_page_contains_non_empty_table(): void
    {
        //$user = User::factory()->create();
        $janr = Genre::create(['name' => 'медодрама-сериал']);

        $response = $this->actingAs($this->user)->get('/janrs');

        $response->assertStatus(200);
        $response->assertDontSee('жанры не найдены');
        $response->assertSee('медодрама-сериал');
        $response->assertViewHas('genres', function ($collection) use ($janr) {
            return $collection->contains($janr);
        });
    }

    // in controller: paginate(10)
    public function test_paginated_janrs_page_doesnt_contain_11th_record(): void
    {
        $janrs = Genre::factory(11)->create();
        $lastRecord = $janrs->last();

        $response = $this->actingAs($this->user)->get('/janrs');

        $response->assertStatus(200);
        $response->assertViewHas('genres', function ($collection) use ($lastRecord) {
            return !$collection->contains($lastRecord);
        });
    }

    // route /janrs closed middleware('auth')
    public function test_unauthenticated_user_cannot_access_janrs_page(): void
    {
        $response = $this->get('/janrs');

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    public function test_success_login_redirect_to_dashboard_page(): void
    {
        User::create([
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('dashboard');
    }
}
