@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/compareCalculations/{{$area->id}}"><button>Porównań Wyniki</button></a><br />

<h3>Porównanie Obliczeń</h3>
<div class="container">

    <table>
        <tr>
            <th>Id</th>
            <th>Level</th>
            <th>Head</th>
            <th>Like</th>
            <th>Change</th>
        </tr>
        @foreach ($calcs AS $p)
        <tr>
            <td>#{{$p['calc_id']}}</td>
            <td>{{$p['level']}}</td>
            <td>{{$p['head']}}</td>
            <td>{{$p['islike']}}</td>
            <td>{{$p['change']}}</td>
        </tr>
        @endforeach
    </table>

</div>


@endsection('content')