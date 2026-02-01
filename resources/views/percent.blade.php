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
      </tr>
@foreach ($levels AS $key => $l) 
   @if ($key > 0)
        <tr>
            <td>{{$key}}</td>
            <td>{{$l['avg']}}</td>
            <td>{{$l['divlvl']}}</td>
            <td>{{ round(1/ $l['divlvl'])}}</td>
             <td>
                @if ($key > 1) 
               {{ $l['toone'] }}
                @endif
             </td>
        </tr>
   @endif     
@endforeach
</table>

   
   <table>
      <tr>
         <th>Level</th>
         <th>Wynik</th>
         <th>Liczba Punktów</th>
      </tr>
      @foreach ($calco AS $p) 
        <tr>
            <td>{{$p['level']}}</td>
            <td>{{$p['sum']}}</td>
            <td>{{$p['points']}}</td>
        </tr>
      @endforeach
</table>

  
</div>

@endsection('content')