<h3>Редактирование жанра</h3>
<div>
    <form action="{{ route('genres.update', $genre) }}" method="post">
        @csrf
        @method('PUT')
        <input type="text" name="name" id="name" value="{{ $genre->name }}" >
        <button type="submit">Обновить</button>
    </form>
</div>
