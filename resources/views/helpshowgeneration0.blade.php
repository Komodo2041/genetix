@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/showgeneration0/{{$area->id}}/{{$dimension}}"><button>Wymiar</button></a><br />


<p>{{$area->id}} : {{$area->name}} - Najlepsze Generacje</p>

<div class="container">

    <table>
        <tr>
            <th>Pattern</th>
            <th>Result</th>
            <th>Type</th>
            <th>Diff</th>
        </tr>
        @foreach ($gen AS $g)
        <tr>
            <th>{{$g['data']}}</th>
            <th>{{$g['result']}}</th>
            <th>{{$g['tryb']}}</th>
            <th>{{$g['diff']}}</th>
        </tr>
        @endforeach
    </table>


</div>

@endsection('content')