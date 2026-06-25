@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/show50Result/{{$area->id}}"><button>Pokaż więcej wyników</button></a><br />

<p>{{$area->name}} - LEVEL: {{$lvlmax}}</p>
<h3>Różnice</h3>
<div class="container">

    <h4 class="hpen">Pionowo</h4>

    @foreach ($reso AS $nrc => $calc)
    <div class="col">
        @foreach ($calc AS $x => $table)
        <div class="totable">
            <table class="level">
                @foreach ($table AS $y => $row)
                <tr>
                    @foreach ($row AS $z => $val)
                    <td @if ($calc[$z][$y][$x]) class="red" @endif>

                    </td>
                    @endforeach
                </tr>
                @endforeach
            </table>

        </div>
        @endforeach
    </div>
    @endforeach

    <div class="col">
        @foreach ($good AS $x => $table)
        <div class="totable">
            <table class="level">
                @foreach ($table AS $y => $row)
                <tr>
                    @foreach ($row AS $z => $val)
                    <td @if ($good[$z][$y][$x]) class="orange" @endif>

                    </td>
                    @endforeach
                </tr>
                @endforeach
            </table>

        </div>
        @endforeach
    </div>



</div>




</div>

@endsection('content')