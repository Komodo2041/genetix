@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

 

<h3>Wybór początkowej populacji - wyniki</h3>
<div class="container">
 
  <table>
     <tr>
 
        <th>
            @if ($order == "selectId" && $desc == "DESC")
               <a class="asc" href="/showPowerSelect/{{$area->id}}/?order=selectId&desc=ASC">Nazwa</a>
            @else
               <a class="desc" href="/showPowerSelect/{{$area->id}}/?order=selectId&desc=DESC">Nazwa</a>
            @endif                           
        </th>
 
        <th>
            @if ($order == "avg" && $desc == "DESC")
               <a class="asc" href="/showPowerSelect/{{$area->id}}/?order=avg&desc=ASC">AVG</a>
            @else
               <a class="desc" href="/showPowerSelect/{{$area->id}}/?order=avg&desc=DESC">AVG</a>
            @endif
        </th>
        <th>
            @if ($order == "max" && $desc == "DESC")
               <a class="asc" href="/showPowerSelect/{{$area->id}}/?order=max&desc=ASC">MAX</a>
            @else
               <a class="desc" href="/showPowerSelect/{{$area->id}}/?order=max&desc=DESC">MAX</a>
            @endif
        </th>
        <th>
            @if ($order == "more" && $desc == "DESC")
               <a class="asc" href="/showPowerSelect/{{$area->id}}/?order=more&desc=ASC">Best</a>
            @else
               <a class="desc" href="/showPowerSelect/{{$area->id}}/?order=more&desc=DESC">Best</a>
            @endif
        </th>        
    </tr>  
@forelse ($calco AS $c)
     <tr>
        <td> {{$pname[$c['selectId']]}}  </td>
        <td>{{$c['avg']}}</td>
        <td>{{$c['max']}}</td>
        <td>{{$c['more']}}</td> 
    </tr>    
@empty
   <tr>
     <td colspan="4"> - Brak Obliczeń -</td>
</tr>
@endforelse

</table>
</div>

@endsection('content')