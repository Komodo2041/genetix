@extends('template')
@section('content')

<h3>Powierzchnie do sprawdzania</h3>

<a href="/mutations"><button>Mutacje - Krzyżowania</button></a>
<a href="/powermatrix/10"><button>Pokaz Matryce siły - size 10</button></a>
<a href="/showCron"><button>Ustawienia Crona</button></a>

<div class="container">

   <table>
      <tr>
         <th>Nazwa</th>
         <th>Wynik</th>
         <th>Opcje</th>
      </tr>
      @forelse ($area AS $a)
      <tr @if (isset($areasMax[$a->id]) && $areasMax[$a->id] > 0) class="green" @endif>
         <td>
            <b>{{$a->id}}</b> {{$a->name}}<br />
            <a href="/hidearea/{{$a->id}}"><button>Ukryj</button></a><br />
            @if ($a->flex == 0)
            <a href="/changeFlex/{{$a->id}}/1"><button>Ustaw flex w pokoleniu</button></a> <br />
            @else
            <a href="/changeFlex/{{$a->id}}/0"><button>Wyłącz flex</button></a> <br />
            @endif
         </td>
         <td style="width:400px;">
            <h4>All: {{$a?->calculations->count()}} </h4>
            @if (isset($calco[$a->id]))
            @foreach ($calco[$a->id] AS $c)
            Level : {{$c["level"]}} - ALL : {{$c["count"]}}<br />
            MAX : {{$c["max"]}} <br />
            AVG : {{$c["avg"]}} <br /><br />
            @endforeach
            @endif
         </td>
         <td>
            <a href="/calcallavg/{{$a->id}}"><button>Przelicz średnie dla poziomów</button></a>
            <a href="/area/showpercent/{{$a->id}}"><button>Pokaż procenty dopasowania</button></a> &nbsp;
            <a href="/area/histogram/{{$a->id}}"><button>Histogram</button></a>&nbsp;

            @if (is_null($a->river))
            <a href="/showRiver/{{$a->id}}"><button>Pokaż wyniki rzek</button></a>&nbsp;
            @endif

            <a href="/showMatrix/{{$a->id}}"><button>Pokaż Matryce Mutacji</button></a>&nbsp;

            <a href="/showCrossMatrix/{{$a->id}}"><button>Pokaż Matryce Krzyżowań</button></a>&nbsp;

            @if ($a->matrixtribe == 0)
            <a href="/turn_matrix/{{$a->id}}"><button>Włącz używany matrycy mutacji</button></a>
            @elseif ($a->matrixtribe == 2)
            <a href="/turnoff_matrix/{{$a->id}}"><button class="secondary">Wyłącz uzywanie matrycy mutacji</button></a>
            @else ($a->matrixtribe == 1)
            <a href="/turnofftwo_matrix/{{$a->id}}"><button>Włącz matrycę tylko dla najlepszych mutacji</button></a>
            @endif
            &nbsp; || &nbsp;
            @if ($a->matrixcross == 0)
            <a href="/setmatrixcross/{{$a->id}}/1"><button>Włącz używany matrycy krzyżowań</button></a>
            @elseif ($a->matrixcross == 2)
            <a href="/setmatrixcross/{{$a->id}}/0"><button class="secondary">Wyłącz uzywanie matrycy krzyżowań</button></a>
            @else ($a->matrixcross == 1)
            <a href="/setmatrixcross/{{$a->id}}/2"><button>Włącz matrycę tylko dla najlepszych krzyżowań</button></a>
            @endif

            <a href="/calculations/{{$a->id}}"><button>Pokaż obliczenia</button></a>

            <a href="/showpower/{{$a->id}}"><button>Pokaż obliczenia matrycy siły</button></a>
            <a href="/showPowerSelect/{{$a->id}}"><button>Pokaż wybór na podstawie siły</button></a>
            <a href="/show5Result/{{$a->id}}"><button>Pokaż 5 różnych wyników</button></a>


            <a href="/showavgcalculations/{{$a->id}}"><button>Szczegóły średnich wyników</button></a>&nbsp;
            <a href="/showPowerBigLayer/{{$a->id}}"><button>Power Big Layer</button></a>&nbsp;
            <a href="/showBigMutationLayer/0/{{$a->id}}"><button>Big Muation Layer</button></a>&nbsp;
            <a href="/showgeneration0/{{$a->id}}/0"><button>Inne (Obliczenia Gen0)</button></a>&nbsp;

            <a href="/showCalcSame/{{$a->id}}"><button>Porównaj obliczenia</button></a>&nbsp;

            <br />
            @foreach ($a->diamonds AS $d)
            <a href="diamond/{{$a->id}}/{{ count($calco[$a->id]) - 1 }}/{{$d->id}}"><button>Oblicz Diament {{$d->id}}</button></a>
            @endforeach
            <br />
            <a href="/area/calc_level2/{{$a->id}}/1">Dokonaj obliczeń obszaru - poziom 1</a><br />
            @if (isset($calco[$a->id]))
            @foreach ($calco[$a->id] AS $c)
            @if ($c['count'] >= 10)
            <a href="/area/calc_level2/{{$a->id}}/{{$c['level'] + 1}}">Dokonaj obliczeń obszaru - poziom {{$c["level"] + 1}}</a><br />
            @endif
            @endforeach
            @endif
         </td>
      </tr>
      @empty
      <tr>
         <td colspan="3" class="td_i">Brak Obszarów do obliczeń</td>
      </tr>
      @endforelse
   </table>


   <form action="" id="formarea" method="Post">
      @csrf
      <input type="hidden" value="1" name="save" />
      <input type="submit" name="action" value="Dodaj test Dno morza" />
      <input type="submit" name="action" value="Dodaj obszar 0 i 1" />
      <input type="submit" name="action" value="Dodaj przekladaniec Z" />
      <input type="submit" name="action" value="Dodaj przekladaniec X" />
      <input type="submit" name="action" value="Dodaj przekladaniec Y" />
      <input type="submit" name="action" value="Generuj jaskinie" />
      <input type="submit" name="action" value="3 różne warstwy Z" />

   </form>

   <br /><br /><br /><br />
   <b>Tryb 0: (Najwyższy lvl do przodu)</b> Uruchomienie {{$nrTimes}} razy:
   @forelse ($area AS $a)
   <a href="/calcareamoretimes/{{$a->id}}/0"><button>{{$a->name}} ID : {{$a->id}}</button></a>
   @empty
   -
   @endforelse

   <br /><br />
   <b>Tryb 1: (4 najwyższe levele)</b> Uruchomienie {{$nrTimes}} razy:
   @forelse ($area AS $a)
   <a href="/calcareamoretimes/{{$a->id}}/1"><button>{{$a->name}} ID : {{$a->id}}</button></a>
   @empty
   -
   @endforelse

   <br /><br />
   <b>Tryb 2: (Staraj się przeskoczyć level)</b> Uruchomienie {{$nrTimes}} razy:
   @forelse ($area AS $a)
   <a href="/calcareamoretimes/{{$a->id}}/2"><button>{{$a->name}} ID : {{$a->id}}</button></a>
   @empty
   -
   @endforelse

   <br /><br />
   <b>Tryb 3: (losowy wybór levelu)</b> Uruchomienie {{$nrTimes}} razy:
   @forelse ($area AS $a)
   <a href="/calcareamoretimes/{{$a->id}}/3"><button>{{$a->name}} ID : {{$a->id}}</button></a>
   @empty
   -
   @endforelse

</div>

@endsection('content')