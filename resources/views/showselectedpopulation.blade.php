@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<h3>Wybór pokolenia Zero</h3>
<div class="container">
 

   
   <table>
      <tr> 
         <th>Level</th>
         <th>Sum</th>
         <th>MAX</th>
         <th>AVG</th>
         <th>Method</th>
      </tr>
      @foreach ($calco AS $p) 
        <tr>
            <td>{{$p['level']}}</td>
            <td>{{$p['count']}}</td>
            <td>{{$p['max']}}</td>
            <td>{{$p['avg']}}</td>
            <td>{{$p['typecalc']}}</td> 
        </tr>
      @endforeach
</table>

  
</div>

@endsection('content')