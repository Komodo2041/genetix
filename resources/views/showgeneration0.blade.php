@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<a href="/calcGeneration0/{{$area->id}}/1"><button>Oblicz 1 generację (0, 50)</button></a>
<a href="/calcGeneration0/{{$area->id}}/2"><button>Oblicz 1 generację (10, 20)</button></a>
<a href="/calcGeneration0/{{$area->id}}/3"><button>Oblicz 1 generację (11, 23)</button></a>
<a href="/calcGeneration0/{{$area->id}}/4"><button>Oblicz 1 generację (Najlepsze z Calculations)</button></a>
<a href="/calcGeneration0/{{$area->id}}/5"><button>Oblicz 1 generację (-5, +5 z najlepszego wyniku)</button></a>

<p>{{$area->id}} : {{$area->name}} - Najlepsze Generacje</p>

<div class="container">
 
   <table>
      <tr>
        <th>Patter</th>
        <th>Result</th>
        <th>Pop</th>
      </tr>
      @foreach ($gen AS $g)
      <tr>
        <th>{{$g->data}}</th>
        <th>{{$g->result}}</th>
        <th>{{$g->population}}</th>
      </tr>      
      @endforeach
</table>
 
  
</div>

@endsection('content')