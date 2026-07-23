@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/calculations/{{$area->id}}"><button>Obliczenia Area</button></a>
<a href="/random50Multiple/{{$area->id}}"><button>Oblicz pokolenia multiple</button></a>
<a href="/random50MultipleTryb2/{{$area->id}}"><button>Oblicz pokolenia multiple Tryb2</button></a>
<a href="/showrandom50Multiple/{{$area->id}}"><button>Pokaż wszystkie obliczenia random50Multiple</button></a>

<h3>Joiner50 - {{$area->name}}</h3>
<div class="container">


    <table>
        <tr>
            <th>Umax</th>
            <th>Better</th>
            <th></th>
        </tr>
        @foreach ($joins AS $j)
        <tr>
            <td>{{$j['max']}}</td>
            <td>{{$j['count']}}</td>
            <td>
                <a href="/showSpecialJoin/{{$area->id}}/{{$j['max']}}"><button> Pokaż szczegóły </button></a>&nbsp;
            </td>
        </tr>
        @endforeach
    </table>


</div>


@endsection('content')