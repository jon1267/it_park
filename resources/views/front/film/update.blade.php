<h3>Обновление фильма</h3>
<div>
    <form action="{{ route('films.update', $film) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Название фильма</label><br>
            <input type="text" name="name" id="name" value="{{ $film->name }}">

        </div><br>
        <div>
            <label for="genres">Жанр фильма (испльзуйте Ctrl+Click) </label><br>
            <select multiple id="genres" name="genres[]" size="5">
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div><br>
        <div>

            @if(!is_null($film->poster))
                <div>
                    <p>Старый постер</p>
                    <img src="{{ asset($film->poster) }}" width="80px" alt="film-poster"><br>
                </div>
            @endif
            <label for="img">Новый постер (необязательно)</label><br>
            <input type="file" name="poster" id="poster">
        </div><br>

        <button type="submit">Обновить</button>
    </form>
</div>
