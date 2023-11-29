<h3>Жанры фильмов</h3>
<div>
    @forelse($genres as $genre)
        <p>{{ $genre->id }} | {{ $genre->name }}</p>
    @empty
        <p>жанры не найдены</p>
    @endforelse
</div>
