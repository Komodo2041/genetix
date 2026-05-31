@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>
<a href="/calcAvgforArea/{{$area->id}}/1"><button>Oblicz brakujące obliczenia</button></a><br/>
<a href="/calcAvgforArea/{{$area->id}}/0"><button>Oblicz średnie obliczeń (Licz wszystkie)</button></a><br/>
<a href="/desilting/{{$area->id}} "><button>Odmulanie</button></a>&nbsp;
<h3>Pokaz średnich oliczeń</h3>
<div class="container">
 
 <table>
     <tr>
         <th>
            @if ($order == "calc_id" && $desc == "DESC")
               <a class="asc" href="/showavgcalculations/{{$area->id}}/?order=calc_id&desc=ASC">#ID</a>
            @else
               <a class="desc" href="/showavgcalculations/{{$area->id}}/?order=calc_id&desc=DESC">#ID</a>
            @endif 
         </th>
        <th>
            @if ($order == "avg" && $desc == "DESC")
               <a class="asc" href="/showavgcalculations/{{$area->id}}/?order=avg&desc=ASC">AVG</a>
            @else
               <a class="desc" href="/showavgcalculations/{{$area->id}}/?order=avg&desc=DESC">AVG</a>
            @endif 
        </th>
        <th>
            @if ($order == "min" && $desc == "DESC")
               <a class="asc" href="/showavgcalculations/{{$area->id}}/?order=min&desc=ASC">MIN</a>
            @else
               <a class="desc" href="/showavgcalculations/{{$area->id}}/?order=min&desc=DESC">MIN</a>
            @endif 
        </th>
        <th>
            @if ($order == "max" && $desc == "DESC")
               <a class="asc" href="/showavgcalculations/{{$area->id}}/?order=max&desc=ASC">MAX</a>
            @else
               <a class="desc" href="/showavgcalculations/{{$area->id}}/?order=max&desc=DESC">MAX</a>
            @endif 
        </th>
        <th>
            @if ($order == "avgdiff" && $desc == "DESC")
               <a class="asc" href="/showavgcalculations/{{$area->id}}/?order=avgdiff&desc=ASC">Diff</a>
            @else
               <a class="desc" href="/showavgcalculations/{{$area->id}}/?order=avgdiff&desc=DESC">Diff</a>
            @endif
        </th>
        <th>
            @if ($order == "variation" && $desc == "DESC")
               <a class="asc" href="/showavgcalculations/{{$area->id}}/?order=variation&desc=ASC">Var</a>
            @else
               <a class="desc" href="/showavgcalculations/{{$area->id}}/?order=variation&desc=DESC">Var</a>
            @endif
        </th>        
        <th>
            @if ($order == "actres" && $desc == "DESC")
               <a class="asc" href="/showavgcalculations/{{$area->id}}/?order=actres&desc=ASC">Res</a>
            @else
               <a class="desc" href="/showavgcalculations/{{$area->id}}/?order=actres&desc=DESC">Res</a>
            @endif
        </th>          
        <th>
            @if ($order == "calclevel" && $desc == "DESC")
               <a class="asc" href="/showavgcalculations/{{$area->id}}/?order=calclevel&desc=ASC">Lvl</a>
            @else
               <a class="desc" href="/showavgcalculations/{{$area->id}}/?order=calclevel&desc=DESC">Lvl</a>
            @endif
        </th>     
    </tr>
   
@forelse ($calco AS $c)
     <tr>
        <td>{{ $c->calc_id }}</td>
        <td>{{ $c->avg }}</td>
        <td>{{ $c->min }}</td>
        <td>{{ $c->max }}</td>
        <td>{{ $c->avgdiff }}</td>
        <td>{{ $c->variation }}</td>
        <td>
            {{ $c->actres }} 
             {{  1 - (($c->max - $c->actres) / $c->avgdiff)  }} 
         </td>
        <td>
           {{ $c->calclevel }}<br/>
             @if (isset($c->calculation->level))
              {{$c->calculation->level}}({{$c->calculation->level - $c->calclevel }})
             @endif 
        </td>
    </tr>    
@empty
   <tr>
     <td colspan="8"> - Brak Obliczeń -</td>
</tr>
@endforelse


 
</div>

@endsection('content')