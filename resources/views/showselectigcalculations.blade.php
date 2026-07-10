@extends('template')
@section('content')

<a href="/"><button>Strona główna </button></a><br />
<a href="/calculations/{{$area->id}}"><button>{{$area->name}}</button></a><br />


<h3>Ilość wybrania danych obliczeń do dalszych obliczeń :</h3>
<p>Area {{$area->name}} : Id: {{$area->id}}</p>
<div class="container">


    @forelse ($calco AS $lvl => $level)
    <b>Level {{$lvl}}</b><br />
    <table>
        <tr>
            <td>Ile razy</td>
            <td>Liczba</td>
            <td>%</td>
        </tr>
        @foreach ($level AS $l)
        <tr>
            <td>{{$l['calculation']}}</td>
            <td>{{$l['count']}}</td>
            <td> {{ $l['count'] / $levl[$lvl] }}</td>
        </tr>
        @endforeach
    </table>

    @empty
    <tr>
        <td colspan="4"> - Brak Obliczeń -</td>
    </tr>
    @endforelse

    </table>
</div>

@endsection('content')