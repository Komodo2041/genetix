@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/samecalculations/{{$area->id}}"><button>Znajdź podobne obliczenia</button></a>&nbsp;
<a href="/showselectigcalculations/{{$area->id}}"><button>Pokaz wybierania obliczeń</button></a>&nbsp;
<a href="/onecalculation/{{$area->id}}"><button>Przelicz obliczenia na jednym zestawie punktów</button></a>&nbsp;
<a href="/bottomLastLayer/{{$area->id}}"><button>Obniż ostatnią warstwę</button></a>&nbsp;
<a href="/area/usedmethods/{{$area->id}}"><button>Wybór pierwszego pokolenia</button></a>&nbsp;
<a href="/area/deleteSameCalc/{{$area->id}}"><button>Usuń Takie same obliczenia</button></a>&nbsp;
<a href="/addTama/{{$area->id}}"><button>Dodaj tamę</button></a>&nbsp;
<a href="/showwagainArea/{{$area->id}}"><button>Pokaż wagi</button></a>&nbsp;
<a href="/spirallMutation/{{$area->id}}"><button>Spiralna mutacja</button></a>&nbsp;
@if ($area->pattern)
<a href="/addRabbit/{{$area->id}}"><button>Dodaj Królika</button></a>&nbsp;
@endif
@if ($area->rabbit)
<a href="/calcRabbit/{{$area->id}}"><button>Oblicz skok zająca</button></a>&nbsp;
@endif
<a href="/diffbestCalculation/{{$area->id}}"><button>Najlepsze wyniki - różnice</button></a>&nbsp;

<h3>Obliczenia dla {{$area->name}} - {{$area->id}}</h3>
<div class="container">



   <table>
      <tr>
         <th>Id</th>
         <th>Level</th>
         <th>Result</th>
         <th>Progress</th>
         <th></th>
      </tr>
      @foreach ($calco AS $p)
      <tr>
         <td>#{{$p['id']}}</td>
         <td>{{$p['level']}}</td>
         <td>{{$p['obtainedresult']}}</td>
         <td>{{$p['progress']}}</td>
         <td>
            <a href="/calculating/progress/{{$p['id']}}"><button>Pokaż postęp</button></a>
         </td>
      </tr>
      @endforeach
   </table>


</div>

@endsection('content')