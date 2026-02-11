@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<h3>Procenty dopasowań</h3>
<div class="container">
 

   
   <table>
      <tr>
         <th>Id</th>
         <th>Level</th>
         <th>Wynik</th>
         <th>Liczba Punktów</th>
      </tr>
      @foreach ($calco AS $p) 
        <tr>
            <td>{{$p['id']}}</td>
            <td>{{$p['level']}}</td>
            <td>{{$p['sum']}}</td>
            <td>{{$p['points']}}</td>
        </tr>
      @endforeach
</table>

  
</div>

@endsection('content')