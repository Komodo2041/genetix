@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a>&nbsp;
<a href="/calcOneMutation/{{$area->id}}"><button>Przelicz jedną mutację</button></a>

<br />

<a href="/calcMatrix/{{$area->id}}/100"><button>Aktualizuj Matryce Mutacji na wiekszej liczbie mutacji - 100</button></a>&nbsp;<br />
<a href="/calcMatrix/{{$area->id}}/200"><button>Aktualizuj Matryce Mutacji na wiekszej liczbie mutacji - 200</button></a>&nbsp;<br />
<a href="/calcMatrix/{{$area->id}}/500"><button>Aktualizuj Matryce Mutacji na wiekszej liczbie mutacji - 500</button></a>&nbsp;<br />
<a href="/calcMatrix/{{$area->id}}/1000"><button>Aktualizuj Matryce Mutacji na wiekszej liczbie mutacji - 1000</button></a>&nbsp;<br />
<h3>Matryca Mutacji</h3>
<div class="container">

   <table>
      <tr>
         <th>
            #
         </th>
         <th>
            @if ($order == "name" && $desc == "DESC")
            <a class="asc" href="/showMatrix/{{$area->id}}/?order=name&desc=ASC">Mutacja</a>
            @else
            <a class="desc" href="/showMatrix/{{$area->id}}/?order=name&desc=DESC">Mutacja</a>
            @endif

         </th>
         <th>
            @if ($order == "result" && $desc == "DESC")
            <a class="asc" href="/showMatrix/{{$area->id}}/?order=result&desc=ASC">Lepsze wyniki</a>
            @else
            <a class="desc" href="/showMatrix/{{$area->id}}/?order=result&desc=DESC">Lepsze wyniki</a>
            @endif
         </th>
         <th>
            @if ($order == "same" && $desc == "DESC")
            <a class="asc" href="/showMatrix/{{$area->id}}/?order=same&desc=ASC">Takie same wyniki</a>
            @else
            <a class="desc" href="/showMatrix/{{$area->id}}/?order=same&desc=DESC">Takie same wyniki</a>
            @endif
         </th>
         <th>
            @if ($order == "calc" && $desc == "DESC")
            <a class="asc" href="/showMatrix/{{$area->id}}/?order=calc&desc=ASC">AVG</a>
            @else
            <a class="desc" href="/showMatrix/{{$area->id}}/?order=calc&desc=DESC">AVG</a>
            @endif
         </th>
         <th>
            @if ($order == "max" && $desc == "DESC")
            <a class="asc" href="/showMatrix/{{$area->id}}/?order=max&desc=ASC">MAX</a>
            @else
            <a class="desc" href="/showMatrix/{{$area->id}}/?order=max&desc=DESC">MAX</a>
            @endif
         </th>
      </tr>
      @forelse ($matrix AS $m)
      <tr>
         <td>{{ $loop->iteration }}</td>
         <td>{{$m['name']}}</td>
         <td>{{$m['result']}}</td>
         <td>{{$m['same']}}</td>
         <td>{{$m['calc']}}</td>
         <td>{{$m['max']}}</td>
      </tr>
      @empty
      <tr>
         <td colspan="3"> - Brak Matrycy -</td>
      </tr>
      @endforelse

   </table>
</div>

@endsection('content')