<h2>Фильмы</h2>
<div>
    <table style="border-collapse: collapse">
        <tr>
            <th>ID</th>
            <th>Название</th>
            {{--<th>Статус</th>--}}
            <th>Постер</th>
        </tr>
        @forelse($films as $film)
                <tr>
                    <td>{{ $film->id }}</td>
                    <td>{{ $film->name }}</td>
                    {{--<td>{{ $film->status }}</td>--}}
                    <td> <img src="{{ asset($film->poster) }}" alt="film-poster" height="50px" /> </td>
                </tr>
        @empty
            <tr>
                <td colspan="3">фильмы не найдены</td>
            </tr>
        @endforelse


    </table>
</div>




<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 50%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>