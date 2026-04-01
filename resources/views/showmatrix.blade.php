@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<h3>Matryca Mutacji</h3>
<div class="container">
 
  <table>
     <tr>
        <th>Mutacja</th>
        <th>Lepsze wyniki</th>
        <th>AVG</th> 
    </tr>  
@forelse ($matrix AS $m)
     <tr>
        <td>{{$m['name']}}</td>
        <td>{{$m['result']}}</td>
        <td>{{$m['calc']}}</td> 
    </tr>    
@empty
   <tr>
     <td colspan="3"> - Brak Matrycy -</td>
</tr>
@endforelse

</table>
</div>

@endsection('content')