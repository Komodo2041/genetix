@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/calculations/{{$area->id}}"><button>Obliczenia</button></a><br />

<a href="/diffbestCalculation/{{$area->id}}"><button>Róznice Najlepszych obliczeń</button></a><br />

<a href="/showrandom50Multiple/{{$area->id}}"><button>Pokaż wszystkie obliczenia random50Multiple</button></a><br />
<a href="/random50Multiple/{{$area->id}}"><button>Oblicz pokolenia multiple Tryb1</button></a><br />
<a href="/random50MultipleTryb2/{{$area->id}}"><button>Oblicz pokolenia multiple Tryb2</button></a><br />

<h3>Crossing - random50Multiple</h3>
<div class="container">


    <table>
        <tr>
            <th>Multiple / Step</th>
            <th>Min</th>
            <th>Max</th>
            <th>Avg</th>
            <th>Better</th>
            <th>All</th>
            <th>Diff</th>
        </tr>
        @foreach ($calco AS $rekord)

        <tr>
            <td>{{$rekord['m']}}</td>
            <td>{{$rekord['min']}}</td>
            <td>{{$rekord['max']}}</td>
            <td>{{$rekord['avg']}}</td>
            <td>{{$rekord['b']}}</td>
            <td>{{$rekord['allP']}}</td>
            <td>{{$rekord['diff']}}</td>
        </tr>

        @endforeach
    </table>


</div>

@endsection('content')