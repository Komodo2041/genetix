@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/show5Result/{{$area->id}}"><button>Pokaż 5 wyników</button></a><br />

<p>{{$area->name}} </p>
<h3>Różnice</h3>
<div class="container">

    <h4 class="hpen">Pionowo</h4>

    @foreach ($reso AS $nrc => $calc)
    <div class="col small">
        <p>
            Level : {{$calc['lvl']}}

        </p>
        @foreach ($calc['data'] AS $x => $table)
        <div class="totable small">
            <table class="level small">
                @foreach ($table AS $y => $row)
                <tr>
                    @foreach ($row AS $z => $val)
                    <td @if ($calc['data'][$z][$y][$x]) class="red" @endif>

                    </td>
                    @endforeach
                </tr>
                @endforeach
            </table>

        </div>
        @endforeach
    </div>
    @endforeach





</div>

</div>

<div style="width:100%; float:left;">
    @if ($nr > 0)
    <a href="/show50Result/{{$area->id}}/{{$nr - 1}}"><button>Poprzednie</button></a>
    @endif

    @if ($nr + 1 < $total)
        <a href="/show50Result/{{$area->id}}/{{$nr + 1}}"><button>Następne</button></a>
        @endif
        {{$nr + 1}} - {{$total}}
</div>

@endsection('content')