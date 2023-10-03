<h3>Создание жанра</h3>
<div>
    <form action="{{ route('genres.store') }}" method="post">
        @csrf
        <input type="text" name="name" id="name" placeholder="Введите жанр фильма">
        <button type="submit">Сохранить</button>
    </form>
</div>
