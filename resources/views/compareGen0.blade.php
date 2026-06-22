@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/showCalcSame/{{$area->id}}"><button>Porównań Wyniki</button></a><br />
<br />
<a href="/compareGen0/{{$area->id}}/20"><button>Porównań Gen0 Z [20 różnic]</button></a>&nbsp;
<a href="/compareGen0/{{$area->id}}/50"><button>Porównań Gen0 Z [50 różnic]</button></a>&nbsp;
<a href="/compareGen0/{{$area->id}}/100"><button>Porównań Gen0 Z [100 różnic]</button></a>&nbsp;
<a href="/compareGen0/{{$area->id}}/200"><button>Porównań Gen0 Z [200 różnic]</button></a>&nbsp;

<h3>Porównanie Obliczeń - {{$count}}</h3>
<div class="container">
    <form action="/setRiverGen0/{{$area->id}}" method="POST">
        @csrf
        <table>
            <tr>
                <th>Pattern</th>
                <th>Result</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($calcs AS $c)
            <tr>
                <td>{{$c['data']}}</td>
                <td>{{$c['res']}}</td>
                <td><input type="checkbox" name="patterns[]" value="{{$c['data']}}" /></td>
                <td>
                    <a href="/calcUp50OneGen0/{{$area->id}}/0/{{$c['gid']}}"> Podnieś GenZ o 50% </a>&nbsp;
                    <a href="/calcUp50OneGen0/{{$area->id}}/1/{{$c['gid']}}"> Obniż GenZ o 50% </a>&nbsp;

                </td>
            </tr>
            @endforeach
        </table>
        <input type="submit" value="Dodaj Rzeki" name="s" />
    </form>
</div>


@endsection('content')