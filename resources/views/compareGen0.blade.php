@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/showCalcSame/{{$area->id}}"><button>Porównań Wyniki</button></a><br />

<h3>Porównanie Obliczeń</h3>
<div class="container">
    <form action="/setRiverGen0/{{$area->id}}" method="POST">
        @csrf
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
                <th><input type="checkbox" name="patterns[]" value="{{$c['data']}}" /></th>
            </tr>
            @endforeach
        </table>
        <input type="submit" value="Dodaj Rzeki" name="s" />
    </form>
</div>


@endsection('content')