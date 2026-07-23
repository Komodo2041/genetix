@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br />
<a href="/calculations/{{$area->id}}"><button>Obliczenia Area</button></a>
<a href="/random50Multiple/{{$area->id}}"><button>Oblicz pokolenia multiple</button></a>
<a href="/random50MultipleTryb2/{{$area->id}}"><button>Oblicz pokolenia multiple Tryb2</button></a>
<a href="/showrandom50Multiple/{{$area->id}}"><button>Pokaż wszystkie obliczenia random50Multiple</button></a><br />
<br />
<a href="/joiner50List/{{$area->id}}"><button>Joiner50</button></a>&nbsp;

<h3>Random50Multiple </h3>
<a name="first"></a>
<a href="#other">Drugie</a>
<div class="container">

    <table>
        <tr>
            <th>#</th>
            <th>
                @if ($order == "res" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=res&desc=ASC">Res</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=res&desc=DESC">Res</a>
                @endif
            </th>
            <th>
                @if ($order == "same" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=same&desc=ASC">Same</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=same&desc=DESC">Same</a>
                @endif
            </th>
            <th>
                @if ($order == "samejoin" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=samejoin&desc=ASC">SameJoin</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=samejoin&desc=DESC">SameJoin</a>
                @endif
            </th>

            <th>
                @if ($order == "mindist" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=mindist&desc=ASC">Min Dist</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=mindist&desc=DESC">Min Dist</a>
                @endif
            </th>
            <th>
                @if ($order == "maxdist" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=maxdist&desc=ASC">Max Dist</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=maxdist&desc=DESC">Max Dist</a>
                @endif
            </th>

            <th>
                @if ($order == "param2" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=param2&desc=ASC">Param 2</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=param2&desc=DESC">Param 2</a>
                @endif
            </th>
            <th>
                @if ($order == "param3" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=param3&desc=ASC">Param 3</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=param3&desc=DESC">Param 3</a>
                @endif
            </th>
            <th>
                @if ($order == "firstdist" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=firstdist&desc=ASC">Dist First</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=firstdist&desc=DESC">Dist First</a>
                @endif
            </th>


        </tr>
        @foreach ($calco AS $record)
        <tr @if ($record['better']) class="green" @endif>
            <td>{{ $loop->iteration }}</td>
            <td>{{$record['res']}}</td>
            <td>#{{$record['same']}}</td>
            <td>{{$record['samejoin']}}</td>
            <td>{{$record['mindist']}}</td>
            <td>{{$record['maxdist']}}</td>
            <td>{{$record['param2']}}</td>
            <td>{{$record['param3']}}</td>
            <td>{{$record['firstdist']}}</td>
        </tr>
        @endforeach
    </table>


</div>
<a name="other"></a>
<a href="#first">Pierwsze</a>
<h3>Other Pop</h3>
<div class="container">

    <table>
        <tr>
            <th>#</th>
            <th>
                @if ($order == "res" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=res&desc=ASC">Res</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=res&desc=DESC">Res</a>
                @endif
            </th>
            <th>
                @if ($order == "same" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=same&desc=ASC">Same</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=same&desc=DESC">Same</a>
                @endif
            </th>
            <th>
                @if ($order == "samejoin" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=samejoin&desc=ASC">SameJoin</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=samejoin&desc=DESC">SameJoin</a>
                @endif
            </th>

            <th>
                @if ($order == "mindist" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=mindist&desc=ASC">Min Dist</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=mindist&desc=DESC">Min Dist</a>
                @endif
            </th>
            <th>
                @if ($order == "maxdist" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=maxdist&desc=ASC">Max Dist</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=maxdist&desc=DESC">Max Dist</a>
                @endif
            </th>

            <th>
                @if ($order == "param2" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=param2&desc=ASC">Param 2</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=param2&desc=DESC">Param 2</a>
                @endif
            </th>
            <th>
                @if ($order == "param3" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=param3&desc=ASC">Param 3</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=param3&desc=DESC">Param 3</a>
                @endif
            </th>
            <th>
                @if ($order == "firstdist" && $desc == "DESC")
                <a class="asc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=firstdist&desc=ASC">Dist First</a>
                @else
                <a class="desc" href="/showSpecialJoin/{{$area->id}}/{{$join}}/?order=firstdist&desc=DESC">Dist First</a>
                @endif
            </th>


        </tr>
        @foreach ($calco2 AS $record)
        <tr @if ($record['better']) class="green" @endif>
            <td>{{ $loop->iteration }}</td>
            <td>{{$record['res']}}</td>
            <td>#{{$record['same']}}</td>
            <td>{{$record['samejoin']}}</td>
            <td>{{$record['mindist']}}</td>
            <td>{{$record['maxdist']}}</td>
            <td>{{$record['param2']}}</td>
            <td>{{$record['param3']}}</td>
            <td>{{$record['firstdist']}}</td>
        </tr>
        @endforeach
    </table>


</div>


@endsection('content')