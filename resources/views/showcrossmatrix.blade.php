@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<a href="/calcCrossMatrix/{{$area->id}}/500"><button>Aktualizuj Matryce krzyżowań na wiekszej liczbie krzyżowań</button></a>&nbsp;

<h3>Matryca Krzyżowań</h3>
<div class="container">
 
  <table>
     <tr>
         <th>
            #
         </th>
        <th>
            @if ($order == "name" && $desc == "DESC")
               <a class="asc" href="/showCrossMatrix/{{$area->id}}/?order=name&desc=ASC">Krzyżowanie</a>
            @else
               <a class="desc" href="/showCrossMatrix/{{$area->id}}/?order=name&desc=DESC">Krzyżowanie</a>
            @endif 
        </th>
        <th>
            @if ($order == "bad_result" && $desc == "DESC")
               <a class="asc" href="/showCrossMatrix/{{$area->id}}/?order=bad_result&desc=ASC">Bad</a>
            @else
               <a class="desc" href="/showCrossMatrix/{{$area->id}}/?order=bad_result&desc=DESC">Bad</a>
            @endif 
        </th>
        <th>
            @if ($order == "middle_result" && $desc == "DESC")
               <a class="asc" href="/showCrossMatrix/{{$area->id}}/?order=middle_result&desc=ASC">Middle</a>
            @else
               <a class="desc" href="/showCrossMatrix/{{$area->id}}/?order=middle_result&desc=DESC">Middle</a>
            @endif 
        </th>
        <th>
            @if ($order == "best_result" && $desc == "DESC")
               <a class="asc" href="/showCrossMatrix/{{$area->id}}/?order=best_result&desc=ASC">Best</a>
            @else
               <a class="desc" href="/showCrossMatrix/{{$area->id}}/?order=best_result&desc=DESC">Best</a>
            @endif
        </th>
        <th>
            @if ($order == "max" && $desc == "DESC")
               <a class="asc" href="/showCrossMatrix/{{$area->id}}/?order=max&desc=ASC">MAX</a>
            @else
               <a class="desc" href="/showCrossMatrix/{{$area->id}}/?order=max&desc=DESC">MAX</a>
            @endif
        </th>  
    </tr>
   
@forelse ($matrix AS $m)
     <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{$m['name']}}</td>
        <td>{{$m['name']}}</td>
        <td>{{$m['bad_result']}}</td>
        <td>{{$m['middle_result']}}</td>
        <td>{{$m['best_result']}}</td>
        <td>{{$m['max']}}</td> 
    </tr>    
@empty
   <tr>
     <td colspan="3"> - Brak Matrycy -</td>
</tr>
@endforelse

</table>
</div>

@endsection('content')