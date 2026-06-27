@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a>&nbsp;
<a href="/advancedgen0/{{$area->id}}"><button>Advanced Gen0 [-50, 50]</button></a>&nbsp;
<a href="/advancedgen0/{{$area->id}}/2"><button>Advanced Gen0 [-20, 20]</button></a>&nbsp;

<br />
<a href="/showgeneration0/{{$area->id}}/0"><button>Gen0</button></a><br />


<p>{{$area->id}} : {{$area->name}} - ADV Gen0 - {{$change}}%</p>

<div class="container">

    <table>
        <tr>
            <th>Id</th>
            <th>Data</th>
            <th>Max</th>
            <th></th>
        </tr>
        @foreach ($res AS $key => $record)
        <tr>
            <td>{{$key}}</td>
            <td>{{$record['data']}}</td>
            <td>
                {{ implode(", ", $record['max']) }}

            </td>
            <td>
                @if ($record['c0'] < 10)
                    <a href="/calcUp50OneGen0/{{$area->id}}/{{$stere[0]}}/{{$key}}"><button>Podnieś GenZ o {{$change}}%</button></a>&nbsp;
                    @endif
                    @if ($record['c1'] < 10)
                        <a href="/calcUp50OneGen0/{{$area->id}}/{{$stere[1]}}/{{$key}}"><button>Obniż GenZ o {{$change}}%</button></a>&nbsp;
                        @endif
                        @if ($record['c0'] > 0 && $record['c1'] > 0)
                        <a href="/calcAdvGen0/{{$key}}/0/{{$tryb}}"><button>Próbuj zaawansowane Obliczanie</button></a>&nbsp;
                        <a href="/showUpDownGen0Calc/{{$key}}/{{$tryb}}"><button>Pokaż obliczenia</button></a>&nbsp;<br />
                        <a href="/calcUp50OneGen0/{{$area->id}}/{{$stere[0]}}/{{$key}}"><button>Podnieś GenZ o {{$change}}%</button></a>&nbsp;
                        <a href="/calcUp50OneGen0/{{$area->id}}/{{$stere[1]}}/{{$key}}"><button>Obniż GenZ o {{$change}}%</button></a>&nbsp;
                        @endif
            </td>
        </tr>
        @endforeach
    </table>


</div>

@endsection('content')