@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<h3>Procenty dopasowań</h3>
<div class="container">
    
   <table>
      <tr>
         <th>Level</th>
         <th>AVG</th> 
         <th>Różnica</th> 
         <th>Różnica - Ułamek</th>
         <th>Przyrost do jedności</th> 
         <th>Wszystkie znalezione</th>
      </tr>
@foreach ($levels AS $key => $l) 
   @if ($key > 0)
        <tr>
            <td>{{$key}} @if  (isset($samecalc[$key])) ({{ $samecalc[$key] }}) @endif</td>
            <td>{{$l['avg']}}</td>
            <td>{{$l['divlvl']}}</td>
            <td>{{ round(1/ $l['divlvl'])}}</td>
             <td>
                @if ($key > 1) 
               {{ $l['toone'] }}
                @endif
             </td>
            <td>
               {{$l["sameinlevel"]}}
            </td>    
        </tr>
   @endif     
@endforeach
</table>

   
   <table>
      <tr>
         <th>Level</th>
         <th>Histogram</th>  
      </tr>
@foreach ($levels AS $key => $l) 
   @if ($key > 0)
        <tr>
            <td>
                <h4>{{$key}}</h4>
            </td>
            <td> 
               @foreach ($l["show_histogram"] AS $key2 => $value2)
                  {{$key2}} : {{$value2}} <br/>
               @endforeach
            </td>
   
        </tr>
   @endif     
@endforeach
</table> 

  
</div>

@endsection('content')