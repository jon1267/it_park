<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Film;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = [
            'Форд против Феррари', 'Искусство бегать под дождем', 'Форсаж',
            'Счастливого Рождества', 'Все начинается завтра', 'Подводная братва',
            'Ледяное сердце', 'Глазами собаки', 'Гонки на миллион',
            'Третий лишний'
        ];

        foreach ($films as $film) {
            Film::create([
                'name' => $film,
                'poster' => 'img/default.jpg',
            ]);
        }
    }
}
