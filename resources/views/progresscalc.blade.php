@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>
<a href="/calculations/{{$area->id}}"><button>Obliczenia dla Area ID {{$area->id}}</button></a><br/>

<h3>Obliczenia dla {{$area->name}} - {{$area->id}}</h3>
<div class="container">
 
   <table>
      <tr>
         <th>Nr Pop</th>
         <th>Level</th>
         <th>Logarytm</th> 
      </tr>
      @foreach ($res AS $p) 
        <tr>
            <td>#{{$p['pop']}}</td>
            <td>{{$p['diff']}}</td> 
            <td> @if ($p['diff'] != 1)
                   {{ log(2, $p['diff']) }}
                @else
                   -
                @endif
            </td>
        </tr>
      @endforeach
</table>

  
</div>

@endsection('content')