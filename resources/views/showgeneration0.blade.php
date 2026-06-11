@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />

<a href="/calcGeneration0/{{$area->id}}/1"><button>Oblicz 1 generację (0, 50)</button></a>
<a href="/calcGeneration0/{{$area->id}}/2"><button>Oblicz 1 generację (10, 20)</button></a>
<a href="/calcGeneration0/{{$area->id}}/3"><button>Oblicz 1 generację (11, 23)</button></a>
<a href="/calcGeneration0/{{$area->id}}/4"><button>Oblicz 1 generację (Najlepsze z Calculations)</button></a>
@if (count($gen) > 0)
<a href="/calcGeneration0/{{$area->id}}/5"><button>Oblicz 1 generację (-5, +5 z najlepszego wyniku)</button></a>
<a href="/calcGeneration0/{{$area->id}}/6"><button>Oblicz 1 generację (-10, +10 z najlepszego wyniku tylko jedna zmiana)</button></a>
<a href="/calcGeneration0/{{$area->id}}/7"><button>Oblicz 1 generację Jeden +10, drugi -10</button></a>
<a href="/calcGeneration0/{{$area->id}}/8"><button>Oblicz 1 generację (Sąsiedzi) Jeden +10, drugi -10</button></a>
<a href="/calcGeneration0/{{$area->id}}/9"><button>Oblicz 1 generację (Dolina) Jeden +10, drugi -10</button></a>
<a href="/calcGeneration0/{{$area->id}}/10"><button>Oblicz 1 generację - Działające zmiany</button></a>
<a href="/calcGeneration0/{{$area->id}}/11"><button>AVG (-5, +5) 20 wyników</button></a>
<a href="/calcGeneration0/{{$area->id}}/12"><button>AVG 20 Best Result</button></a>
@endif

<p>{{$area->id}} : {{$area->name}} - Najlepsze Generacje</p>

<div class="container">

  <table>
    <tr>
      <th>Patter</th>
      <th>Result</th>
      <th>Type</th>
      <th>Pop</th>
    </tr>
    @foreach ($gen AS $g)
    <tr>
      <th>{{$g->data}}</th>
      <th>{{$g->result}}</th>
      <th>{{$g->tryb}}</th>
      <th>{{$g->population}}</th>
    </tr>
    @endforeach
  </table>


</div>

@endsection('content')