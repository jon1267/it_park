<h3>Жанры фильмов</h3>
<div>
    @foreach($genres as $genre)
        <p>{{ $genre->id }} | {{ $genre->name }}</p>
    @endforeach
</div>
