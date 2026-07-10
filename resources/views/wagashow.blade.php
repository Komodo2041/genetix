@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/showwagainArea/{{$aid}}"><button> Wagi </button></a><br />
<a href="/calculations/{{$aid}}"><button> Obliczenia </button></a><br />

<h3>Różnice - Calculation : {{$cid}}</h3>
<div class="container">

    <h4 class="hpen">Pionowo</h4>
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

        <table class="level">
            @foreach ($table AS $y => $row)
            <tr>
                @foreach ($row AS $z => $val)
                <td @if ($area[$z][$y][$x]) class="red" @endif>

                </td>
                @endforeach
            </tr>
            @endforeach
        </table>

        <table class="level">
            @foreach ($table AS $y => $row)
            <tr>
                @foreach ($row AS $z => $val)
                <td @if ($waga[$z][$y][$x]) class="red2" @endif>

                </td>
                @endforeach
            </tr>
            @endforeach
        </table>

        <table class="level">
            @foreach ($table AS $y => $row)
            <tr>
                @foreach ($row AS $z => $val)
                <td @if ($area[$z][$y][$x] !=$calc[$z][$y][$x] && $area[$z][$y][$x]==1) class="red" @endif
                    @if ($area[$z][$y][$x] !=$calc[$z][$y][$x] && $area[$z][$y][$x]==0) class="red2" @endif>

                </td>
                @endforeach
            </tr>
            @endforeach
        </table>



    </div>
    @endforeach




</div>

@endsection('content')