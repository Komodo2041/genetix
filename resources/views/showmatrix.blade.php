@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<a href="/calcMatrix/{{$area->id}}/500"><button>Aktualizuj Matryce Mutacji na wiekszej liczbie mutacji</button></a>&nbsp;

<h3>Matryca Mutacji</h3>
<div class="container">
 
  <table>
     <tr>
        <th>Mutacja</th>
        <th>Lepsze wyniki</th>
        <th>Takie same wyniki</th>
        <th>AVG</th>
        <th>MAX</th>  
    </tr>  
@forelse ($matrix AS $m)
     <tr>
        <td>{{$m['name']}}</td>
        <td>{{$m['result']}}</td>
        <td>{{$m['same']}}</td>
        <td>{{$m['calc']}}</td>
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