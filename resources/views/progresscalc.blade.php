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
      </tr>
      @foreach ($res AS $r) 
        <tr>
            <td>#{{$p['pop']}}</td>
            <td>{{$p['diff']}}</td> 
 
        </tr>
      @endforeach
</table>

  
</div>

@endsection('content')