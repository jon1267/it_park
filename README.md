## Feature Tests, Pest tests

Простое АПИ для фреймворка Laravel.
Созданы 3 миграции в базу данных с помощью Artisan.
Создать seeds для тестового заполнения вышеуказанных таблиц.
Создать модели, контроллеры, для создания, вывода, редактирования и удаления записей.
Создать контроллеры REST API для выборки и пагинации данных в формате json.


## web routes

GET|HEAD        films ... films.index › FilmController@index <br>
POST            films ... films.store › FilmController@store <br>
GET|HEAD        films/create ... films.create › FilmController@create <br>
PUT|PATCH       films/{film} ... films.update › FilmController@update <br>
DELETE          films/{film} ... films.destroy › FilmController@destroy<br>
GET|HEAD        films/{film}/edit ... films.edit › FilmController@edit <br>
GET|HEAD        films/{film}/publish ... FilmController@publish <br>
GET|HEAD        films/{film}/unpublish ... FilmController@unPublish <br>

GET|HEAD        genres .... genres.index › GenreController@index <br>
POST            genres .... genres.store › GenreController@store <br>
GET|HEAD        genres/create  ... genres.create › GenreController@create <br>
PUT|PATCH       genres/{genre} ... genres.update › GenreController@update <br>
DELETE          genres/{genre} ... genres.destroy › GenreController@destroy <br>
GET|HEAD        genres/{genre}/edit ... genres.edit › GenreController@edit <br>


### api routes

GET|HEAD        api/film/{id} ..... Api\ApiFilmController@oneFilm <br>
GET|HEAD        api/films ......... Api\ApiFilmController@allFilms <br>
GET|HEAD        api/genre/{id}/films ... Api\ApiGenreController@genreFilms <br>
GET|HEAD        api/genres ..............Api\ApiGenreController@genres <br>

