@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/showCalcSame/{{$area->id}}"><button>Porównań Wyniki</button></a><br />

<h3>Porównanie Obliczeń</h3>
<div class="container">

    <table>
        <tr>
            <th>Pattern</th>
            <th>Result</th>
            <th></th>
        </tr>
        @foreach ($calcs AS $c)
        <tr>
            <th>{{$c['data']}}</th>
            <th>{{$c['res']}}</th>
            <th></th>
        </tr>
        @endforeach
    </table>

</div>


@endsection('content')