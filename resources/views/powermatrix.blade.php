@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>
<a href="/see10Layerpower/10"><button>Pokaż 10 warstw</button></a><br/>

<h3>Matryca siły - size {{$size}}</h3>
<a href="/calcpowermatrix/10"><button>Oblicz Matryce siły</button></a>   

@if ($power) 
   @foreach ($power AS $x => $table) 
<div style="width:100%;">
   <table >
   @foreach ($table AS $y => $row)
      <tr>
      @foreach ($row AS $z => $val)
         <td class="showdata">
            {{$power[$z][$y][$x]}}
         </td>
      @endforeach 
      </tr>
   @endforeach
</table>
  @endforeach
@else
   <p>Brak obliczeń dla tej wielkości</p>
@endif
  
</div>

@endsection('content')