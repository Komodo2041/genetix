@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<a href="/calcAvgforArea/{{$area->id}}"><button>Oblicz średnie obliczeń</button></a>&nbsp;

<h3>Pokaz średnich oliczeń</h3>
<div class="container">
 
 
</div>

@endsection('content')