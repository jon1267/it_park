<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\Genre;

class FilmsGenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films =  Film::all();

        foreach ($films as $film) {
            $genres = Genre::inRandomOrder()->take(rand(2,3))->pluck('id');
            $film->genres()->attach($genres);
        }
    }
}
