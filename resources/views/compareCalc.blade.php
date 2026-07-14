@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a>&nbsp;
<a href="/compareGen0/{{$area->id}}/50"><button>Porównań Gen0 Z</button></a>

<br />
<a href="/compareCalculations/{{$area->id}}"><button>Porównań Wyniki</button></a><br />
<a href="/bigcrossingtwocalc/{{$area->id}}"><button>Big Crossing 2 Calculation</button></a>
<a href="/crossingOneLevel/{{$area->id}}"><button>Big Crossing - Level 1</button></a>
<br />

<a href="/checkBlob/{{$area->id}}/0"><button>Blob 1 levela</button></a>
<a href="/checkBlob/{{$area->id}}/1"><button>Blob 2 levela</button></a>
<a href="/checkBlob/{{$area->id}}/2"><button>Blob 10 najlepszych Head</button></a>

<h3>Porównanie Obliczeń</h3>
<div class="container">

    <table>
        <tr>
            <th>Id</th>
            <th>Level</th>
            <th>Head</th>
            <th>Like</th>
            <th>Change</th>
            <th>Board</th>
            <th></th>
        </tr>
        @foreach ($calcs AS $p)
        <tr>
            <td>#{{$p['calc_id']}}</td>
            <td>{{$p['level']}}</td>
            <td>{{$p['head']}}</td>
            <td>{{$p['islike']}}</td>
            <td>{{$p['change']}}</td>
            <td>{{$p['board']}}</td>
            <td><a href="/showerror/{{$p['calc_id']}}"><button>Pokaż</button></a></td>
        </tr>
        @foreach ($p['all'] AS $p2)
        <tr>
            <td>#{{$p2['calc_id']}}</td>
            <td>{{$p2['level']}}</td>
            <td>{{$p2['head']}}</td>
            <td>{{$p2['islike']}}</td>
            <td>{{$p2['change']}}</td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
        @endforeach
    </table>

</div>


@endsection('content')