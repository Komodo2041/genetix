@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<a href="/calcAvgforArea/{{$area->id}}"><button>Oblicz średnie obliczeń</button></a>&nbsp;

<h3>Pokaz średnich oliczeń</h3>
<div class="container">
 
 <table>
     <tr>
         <th>
            #Id
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
            @if ($order == "actres" && $desc == "DESC")
               <a class="asc" href="/showavgcalculations/{{$area->id}}/?order=actres&desc=ASC">Res</a>
            @else
               <a class="desc" href="/showavgcalculations/{{$area->id}}/?order=actres&desc=DESC">Res</a>
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
        <td>{{ $c->actres }}</td>
    </tr>    
@empty
   <tr>
     <td colspan="6"> - Brak Obliczeń -</td>
</tr>
@endforelse


 
</div>

@endsection('content')