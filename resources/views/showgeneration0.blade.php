@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<a href="/calcGeneration0/{{$area->id}}/1"><button>Oblicz 1 generację (0, 50)</button></a>
<a href="/calcGeneration0/{{$area->id}}/2"><button>Oblicz 1 generację (10, 20)</button></a>
<a href="/calcGeneration0/{{$area->id}}/3"><button>Oblicz 1 generację (11, 23)</button></a>


<p>{{$area->id}} : {{$area->name}} - Najlepsze Generacje</p>

<div class="container">
 
 TUTAJ BĘDZIE POKAZ NAJLPESZYCH WYNIKÓW
   
 
 
  
</div>

@endsection('content')