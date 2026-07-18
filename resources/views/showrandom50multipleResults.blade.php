@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/calculations/{{$area->id}}"><button>Obliczenia Area</button></a><br />
<a href="/random50Multiple/{{$area->id}}"><button>Oblicz pokolenia multiple</button></a><br />
<a href="/random50MultipleTryb2/{{$area->id}}"><button>Oblicz pokolenia multiple Tryb2</button></a><br />


<h3>Random50Multiple </h3>

<div class="container">

    <table>
        <tr>
            <th>#</th>
            <th>Res</th>
            <th>Same</th>
            <th>SameJoin</th>
        </tr>
        @foreach ($calco AS $record)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{$record['res']}}</td>
            <td>{{$record['acalc']}}</td>
            <td>{{$record['joincalc']}}</td>
        </tr>
        @endforeach
    </table>


</div>

@endsection('content')