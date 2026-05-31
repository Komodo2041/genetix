@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>
 
<a href="/calcPowerBigLayer/{{$area->id}}/100"><button>Aktualizuj Matryce Mutacji na wiekszej wywołań - 100</button></a>&nbsp;<br/>
<a href="/calcPowerBigLayer/{{$area->id}}/500"><button>Aktualizuj Matryce Mutacji na wiekszej wywołań- 500</button></a>&nbsp;<br/>
<a href="/calcPowerBigLayer/{{$area->id}}/1000"><button>Aktualizuj Matryce Mutacji na wiekszej wywołań - 1000</button></a>&nbsp;<br/>
<h3>Matryca Wyników Mutatora PowerBigLayer</h3>
<div class="container">
 
 

</table>
</div>

@endsection('content')