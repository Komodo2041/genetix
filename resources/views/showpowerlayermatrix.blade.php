@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />

<a href="/calcPowerBigLayer/{{$area->id}}/100"><button>Aktualizuj Matryce na wiekszej wywołań - 100</button></a>&nbsp;<br />
<a href="/calcPowerBigLayer/{{$area->id}}/200"><button>Aktualizuj Matrycena wiekszej wywołań - 200</button></a>&nbsp;<br />
<a href="/calcPowerBigLayer/{{$area->id}}/500"><button>Aktualizuj Matrycena wiekszej wywołań- 500</button></a>&nbsp;<br />
<a href="/calcPowerBigLayer/{{$area->id}}/1000"><button>Aktualizuj Matryce na wiekszej wywołań - 1000</button></a>&nbsp;<br />
<h3>Matryca Wyników Mutatora PowerBigLayer</h3>
<div class="container">

   <table>
      <tr>
         <th>
            #
         </th>
         <th>
            @if ($order == "name" && $desc == "DESC")
            <a class="asc" href="/showPowerBigLayer/{{$area->id}}/?order=name&desc=ASC">Mutacja</a>
            @else
            <a class="desc" href="/showPowerBigLayer/{{$area->id}}/?order=name&desc=DESC">Mutacja</a>
            @endif
         </th>
         <th>
            @if ($order == "percent" && $desc == "DESC")
            <a class="asc" href="/showPowerBigLayer/{{$area->id}}/?order=percent&desc=ASC">%</a>
            @else
            <a class="desc" href="/showPowerBigLayer/{{$area->id}}/?order=percent&desc=DESC">%</a>
            @endif
         </th>
         <th>
            @if ($order == "avg" && $desc == "DESC")
            <a class="asc" href="/showPowerBigLayer/{{$area->id}}/?order=avg&desc=ASC">AVG</a>
            @else
            <a class="desc" href="/showPowerBigLayer/{{$area->id}}/?order=avg&desc=DESC">AVG</a>
            @endif
         </th>
         <th>
            @if ($order == "max" && $desc == "DESC")
            <a class="asc" href="/showPowerBigLayer/{{$area->id}}/?order=max&desc=ASC">MAX</a>
            @else
            <a class="desc" href="/showPowerBigLayer/{{$area->id}}/?order=max&desc=DESC">MAX</a>
            @endif
         </th>
         <th>
            @if ($order == "better" && $desc == "DESC")
            <a class="asc" href="/showPowerBigLayer/{{$area->id}}/?order=better&desc=ASC">Better</a>
            @else
            <a class="desc" href="/showPowerBigLayer/{{$area->id}}/?order=better&desc=DESC">Better</a>
            @endif
         </th>


      </tr>

      @forelse ($matrix AS $m)
      <tr>
         <td>{{ $loop->iteration }}</td>
         <td>{{$m['name']}}</td>
         <td>{{$m['percent']}}</td>
         <td>{{$m['avg']}}</td>
         <td>{{$m['max']}}</td>
         <td>{{$m['better']}}</td>
      </tr>
      @empty
      <tr>
         <td colspan="6"> - Brak Matrycy -</td>
      </tr>
      @endforelse

   </table>
</div>

@endsection('content')