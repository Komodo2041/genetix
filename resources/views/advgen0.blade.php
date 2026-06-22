@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/showgeneration0/{{$area->id}}/0"><button>Gen0</button></a><br />


<p>{{$area->id}} : {{$area->name}} - ADV Gen0</p>

<div class="container">

    <table>
        <tr>
            <th>Id</th>
            <th>Max</th>
            <th></th>
        </tr>
        @foreach ($res AS $key => $record)
        <tr>
            <td>{{$key}}</td>
            <td>
                {{ implode(", ", $record['max']) }}

            </td>
            <td>
                @if ($record['c23'] == 0)
                <a href="/calcUp50OneGen0/{{$area->id}}/0/{{$key}}"><button>Podnieś GenZ o 50%</button></a>&nbsp;
                @endif
                @if ($record['c23'] == 0)
                <a href="/calcUp50OneGen0/{{$area->id}}/1/{{$key}}"><button>Obniż GenZ o 50%</button></a>&nbsp;
                @endif
                @if ($record['c23'] > 0 && $record['c24'] > 0)
                <a href="/calcAdvGen0/{{$key}}/0"><button>Próbuj zaawansowane Obliczanie</button></a>&nbsp;
                @endif
            </td>
        </tr>
        @endforeach
    </table>


</div>

@endsection('content')