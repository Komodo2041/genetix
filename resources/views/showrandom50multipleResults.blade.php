@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/calculations/{{$area->id}}"><button>Obliczenia Area</button></a>
<a href="/random50Multiple/{{$area->id}}"><button>Oblicz pokolenia multiple</button></a>
<a href="/random50MultipleTryb2/{{$area->id}}"><button>Oblicz pokolenia multiple Tryb2</button></a>
<a href="/showrandom50Multiple/{{$area->id}}"><button>Pokaż wszystkie obliczenia random50Multiple</button></a>

<h3>Random50Multiple </h3>

<div class="container">

    <table>
        <tr>
            <th>#</th>
            <th>Res</th>
            <th>Same</th>
            <th>SameJoin</th>
            <th>Min Dist</th>
            <th>Max Dist</th>
            <th>Param</th>
            <th>Mediana</th>
        </tr>
        @foreach ($calco AS $record)
        <tr @if ($record['green']) class="green" @endif>
            <td>{{ $loop->iteration }}</td>
            <td>{{$record['res']}}</td>
            <td>#{{$record['acalc']}}</td>
            <td>{{$record['joincalc']}}</td>
            <td>{{$record['mindist']}}</td>
            <td>{{$record['maxdist']}}</td>
            <td>{{$record['param_2']}}</td>
            <td>{{$record['mediana']}}</td>
        </tr>
        @endforeach
    </table>


</div>

@endsection('content')