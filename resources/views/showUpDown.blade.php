@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/advancedgen0/{{$area->id}}"><button>Advanced Gen0</button></a><br />
<a href="/showgeneration0/{{$area->id}}/0"><button>Gen0</button></a><br />


<p>{{$area->id}} : {{$area->name}} - ADV Show Gen0</p>

<div class="container">
    <h3>{{ $gen0->result}} - {{ $gen0->data}}</h3>
    <table id="colorTable">
        <tr>
            <th>Changes</th>
            <th>Result</th>
            <th>Diff</th>
            <th>Changes</th>
            <th>Result</th>
            <th>Diff</th>
        </tr>
        @foreach ($up AS $key => $record)
        <tr>
            <td @if ($up[$key]['result'] - $gen0->result > 0) class="green" @endif>{{$up[$key]['changes']}}</td>
            <td>{{$up[$key]['result']}}</td>
            <td>{{$up[$key]['result'] - $gen0->result}}</td>
            <td @if ($down[$key]['result'] - $gen0->result > 0) class="green" @endif>{{$down[$key]['changes']}}</td>
            <td>{{$down[$key]['result']}}</td>
            <td>{{$down[$key]['result'] - $gen0->result}}</td>
        </tr>
        @endforeach
    </table>


</div>

@endsection('content')