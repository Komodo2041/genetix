@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/calculations/{{$area->id}}"><button>Obliczenia</button></a><br />

<h3>Różnice wyników</h3>
<div class="container">

    <h3>Punkty wpsólne z Area</h3>
    <table>
        <tr>
            <th>Calculation Id</th>
            <th>Result</th>
            <th>Same</th>
        </tr>
        @foreach ($calco AS $cid => $diff)

        <tr>
            <td>{{$cid}}</td>
            <td>{{$diff['res']}}</td>
            <td>{{$diff['diff']}}</td>
        </tr>

        @endforeach
    </table>

    <h3> Różnice Obliczenia</h3>

    <table class="small">

        <tr>
            <th>X</th>
            @foreach ($res AS $cid => $cid2)
            <th>{{$cid}}</th>
            @endforeach
        </tr>
        @foreach ($res AS $cid => $res2)
        <tr>
            <td>{{$cid}}</th>
                @foreach ($res2 AS $cid2 => $v)
            <td>
                {{$v}} <br />
                {{$cdiff[$cid][$cid2]}}%
            </td>
            @endforeach
        </tr>
        @endforeach


    </table>


</div>

@endsection('content')