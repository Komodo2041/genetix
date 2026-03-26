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
          <th>Name</th>
         <th>Method</th>
      </tr>
       @php $lastLevel = null; @endphp
      @foreach ($calco AS $p) 

         {{-- Sprawdź, czy to nie jest pierwsza iteracja i czy poziom się zmienił --}}
         @if ($lastLevel !== null && $lastLevel !== $p['level'])
            <tr class="spacer">
                  <td colspan="6" style="height: 20px;"></td> {{-- Pusty wiersz --}}
            </tr>
         @endif      
        <tr>
            <td>{{$p['level']}}</td>
            <td>{{$p['count']}}</td>
            <td>{{$p['max']}}</td>
            <td>{{$p['avg']}}</td>
            <td>{{$names[$p['typecalc']]}}</td>
            <td>{{$p['typecalc']}}</td> 
        </tr>
          @php $lastLevel = $p['level']; @endphp
      @endforeach
</table>

  
</div>

@endsection('content')