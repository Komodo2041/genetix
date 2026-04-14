@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<a href="/calcCrossMatrix/{{$area->id}}/500"><button>Aktualizuj Matryce Mutacji na wiekszej liczbie mutacji</button></a>&nbsp;

<h3>Matryca Krzyżowań</h3>
<div class="container">
 
  <table>
     <tr>
        <th>Krzyżowanie</th>
        <th>Bad</th>
        <th>Middle</th>
        <th>Result</th>
        <th>MAX</th>  
    </tr>  
@forelse ($matrix AS $m)
     <tr>
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