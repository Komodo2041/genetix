@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />

<div class="groupBox">
  <a href="/showgeneration0/{{$area->id}}/0"><button @if ($dimension==0) class="gray" @endif>Obliczenia Gen0 - Z</button></a>&nbsp;
  <a href="/showgeneration0/{{$area->id}}/1"><button @if ($dimension==1) class="gray" @endif>Obliczenia Gen0 - X</button></a>&nbsp;
  <a href="/showgeneration0/{{$area->id}}/2"><button @if ($dimension==2) class="gray" @endif>Obliczenia Gen0 - Y</button></a>&nbsp;<br />
  <a href="/calcAltgeneration0/{{$area->id}}/0"><button>Ciąg obliczeń Gen0 - Z</button></a>&nbsp;
  <a href="/calcAltgeneration0/{{$area->id}}/1"><button>Ciąg obliczeń Gen0 - X</button></a>&nbsp;
  <a href="/calcAltgeneration0/{{$area->id}}/2"><button>Ciąg obliczeń Gen0 - Y</button></a>&nbsp;
  <a href="/calc3DimGen0/{{$area->id}}"><button>Oblicz na podstawie Z,X,Y</button></a>&nbsp;
</div>
<div class="groupBox">
  <a href="/showgeneration0/{{$area->id}}/{{$dimension}}"><button @if ($onshow==0) class="gray" @endif>All</button></a>&nbsp;
  <a href="/showgeneration0/{{$area->id}}/{{$dimension}}?onshow=1"><button @if ($onshow==1) class="gray" @endif>Kategoria 0-3</button></a>&nbsp;
  <a href="/showgeneration0/{{$area->id}}/{{$dimension}}?onshow=2"><button @if ($onshow==2) class="gray" @endif>Kategoria 12-14</button></a>&nbsp;

  <a href="/helpgeneration0/{{$area->id}}/1"><button>Pomocene Obliczenia Gen0 - X</button></a>&nbsp;
  <a href="/helpgeneration0/{{$area->id}}/2"><button>Pomocne Obliczenia Gen0 - Y</button></a>&nbsp;

</div>
<div class="groupBox">
  <a href="/calcGeneration0/{{$area->id}}/1/{{$dimension}}"><button>Oblicz 1 generację (0, 50)</button></a>
  <a href="/calcGeneration0/{{$area->id}}/2/{{$dimension}}"><button>Oblicz 1 generację (10, 20)</button></a>
  <a href="/calcGeneration0/{{$area->id}}/3/{{$dimension}}"><button>Oblicz 1 generację (11, 23)</button></a>
</div>
<div class="groupBox">
  <a href="/calcGeneration0/{{$area->id}}/4/{{$dimension}}"><button>Oblicz 1 generację (Najlepsze z Calculations)</button></a>
  @if (count($gen) > 0)
  <a href="/calcGeneration0/{{$area->id}}/5/{{$dimension}}"><button>Oblicz 1 generację (-5, +5 z najlepszego wyniku)</button></a>
  <a href="/calcGeneration0/{{$area->id}}/15/{{$dimension}}"><button>Oblicz 1 generację (-2, +2 z najlepszego wyniku)</button></a>
  <a href="/calcGeneration0/{{$area->id}}/16/{{$dimension}}"><button>Oblicz 1 generację (-1, +1 z najlepszego wyniku)</button></a>
  <a href="/calcGeneration0/{{$area->id}}/6/{{$dimension}}"><button>Oblicz 1 generację (-10, +10 z najlepszego wyniku tylko jedna zmiana)</button></a>
  <a href="/calcGeneration0/{{$area->id}}/18/{{$dimension}}"><button>Oblicz 1 generację (-2, +2 z najlepszego wyniku tylko jedna zmiana)</button></a>
  <a href="/calcGeneration0/{{$area->id}}/7/{{$dimension}}"><button>Oblicz 1 generację Jeden +10, drugi -10</button></a>
  <a href="/calcGeneration0/{{$area->id}}/17/{{$dimension}}"><button>Oblicz 1 generację Jeden +1, drugi -1</button></a>
  <a href="/calcGeneration0/{{$area->id}}/8/{{$dimension}}"><button>Oblicz 1 generację (Sąsiedzi) Jeden +10, drugi -10</button></a>
  <a href="/calcGeneration0/{{$area->id}}/9/{{$dimension}}"><button>Oblicz 1 generację (Dolina) Jeden +10, drugi -10</button></a>
  <a href="/calcGeneration0/{{$area->id}}/10/{{$dimension}}"><button>Oblicz 1 generację - Działające zmiany</button></a>
  <a href="/calcGeneration0/{{$area->id}}/11/{{$dimension}}"><button>AVG (-5, +5) 20 wyników</button></a>
  @endif
</div>
@if (count($gen) > 0)
<div class="groupBox">
  <a href="/calcGeneration0/{{$area->id}}/12/{{$dimension}}"><button>Del 50% Change And Add 50% Again</button></a>
  <a href="/calcGeneration0/{{$area->id}}/13/{{$dimension}}"><button>(Del 50% Change And Add 50% Again) -> Next +5, -5%</button></a>
  <a href="/calcGeneration0/{{$area->id}}/14/{{$dimension}}"><button>AVG DelAdd 50%</button></a>
</div>
<div class="groupBox">
  <a href="/calcGeneration0/{{$area->id}}/19/{{$dimension}}"><button>AVG 20 Best Result</button></a>
</div>

@endif

<p>{{$area->id}} : {{$area->name}} - Najlepsze Generacje</p>

<div class="container">

  <table>
    <tr>
      <th>Pattern</th>
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