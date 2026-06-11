@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />

<p>Power Layer size - {{$size}}</p>
<h3>Różnice</h3>
<div class="container">

    <h4 class="hpen">Pionowo</h4>
    @php $dem = 0; @endphp
    @foreach ($reso AS $nrc => $calc)
    @php $dem++; @endphp

    @if ($dem == 1 || $dem == 6)
    <div style="width:100%; float:left;">
        @endif
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

        @if ($dem == 5 || $dem == 10)
    </div>
    @endif

    @endforeach


</div>




</div>

@endsection('content')