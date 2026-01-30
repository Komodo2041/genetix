@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<h3>Krzyzowania i mutacje</h3>
<div class="container">
    @if ($nc != "") 
       <p>Brak Krzyżowań : {{$nc}}</p>
    @nedif
    @if ($nm != "") 
       <p>Brak Mutacji : {{$nm}}</p>
    @nedif    
   <table>
      <tr>
         <th>Nazwa</th>
         <th>Ilość</th>
         <th>Procent</th>
         <th>Krzyżowanie</th>
         <th>Mutacja</th>
      </tr>
      @foreach ($mutations AS $key => $value) 
        <tr>
            <td>{{$key}}</td>
            <td>{{$value}}</td>
            <td>{{ ($value / $all) * 100 }}</td>
            <td>
               @if (in_array($key, $cross))
                  TAK
               @endif
            </td>
            <td>
               @if (in_array($key, $mutaions))
                  TAK
               @endif 
            </td>
        </tr>
      @endforeach
</table>

  
</div>

@endsection('content')