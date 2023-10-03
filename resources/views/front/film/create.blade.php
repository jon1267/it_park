<h3>Создание фильма</h3>
<div>
    <form action="{{ route('films.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Название фильма</label><br>
            <input type="text" name="name" id="name" placeholder="Введите название фильма">
        </div><br>
        <div>
            <label for="title">Жанр фильма (испльзуйте Ctrl+Click) </label><br>
            <select multiple id="genres" name="genres[]" size="5">
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div><br>
        <div>
            <label for="poster">Постер фильма (необязательно)</label><br>
            <input type="file" name="poster" id="poster">
        </div><br>

        <button type="submit">Сохранить</button>
    </form>
</div>
