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

    public function test_create_janr_successful(): void
    {
        $janr = ['name' => 'медодрама-сериал'];
        $response = $this->actingAs($this->user)->post('/janrs', $janr);

        $response->assertStatus(200);
        $this->assertEquals('Новый жанр создан', $response['message']);
        $this->assertDatabaseHas('genres', $janr);

        $lastRecord = Genre::latest()->first();
        $this->assertEquals($janr['name'], $lastRecord->name);
    }

    public function test_janr_edit_form_contains_correct_values(): void
    {
        $janr = Genre::factory()->create();
        //$lastRecord = Genre::latest()->first(); //this not need here

        $response = $this->actingAs($this->user)->get('janrs/'. $janr->id .'/edit');

        $response->assertStatus(200);
        $response->assertSee('value="'.$janr->name.'"', false);
        $response->assertViewHas('genre', $janr);
        //$this->assertEquals($janr->name, $lastRecord->name); //not need here
    }

    public function test_janr_update_validation_error_redirect_back_to_form(): void
    {
        $janr = Genre::factory()->create();

        $response = $this->actingAs($this->user)->put('janrs/'. $janr->id, ['name' => '']);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
        $response->assertInvalid(['name']); //same as line above
    }

    public function test_janr_delete_successful()
    {
        $janr = Genre::factory()->create();

        $response = $this->actingAs($this->user)->delete('janrs/' . $janr->id);

        $response->assertStatus(200);
        $this->assertEquals('Жанр удален', $response['message']);
        $this->assertDatabaseMissing('genres', $janr->toArray());
        $this->assertDatabaseCount('genres', 0);
    }

    public function test_api_returns_janrs_list()
    {
        $janr = Genre::factory()->create();

        $response = $this->getJson('/api/genres'); //our api has not route '/api/janrs' but /genres present
        $responseJanr = $response['data'][0]; //response()->json($result) return [data {...}]
        $createdJanr = $janr->toArray();

        $this->assertEquals($responseJanr['id'], $createdJanr['id']);
        $this->assertEquals($responseJanr['name'], $createdJanr['name']);
    }
}
