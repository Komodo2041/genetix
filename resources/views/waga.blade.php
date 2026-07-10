@extends('template')
@section('content')

<a href="/"><button>Strona główna </button></a><br />
<a href="/calculations/{{$area->id}}"><button> Obliczenia {{$area->name}}</button></a><br />


<div class="container">




    <table>
        <tr>
            <td>ID</td>
            <td>Res</td>
            <td>Lvl</td>
            <td> </td>
        </tr>
        @forelse ($calco AS $l)
        <tr>
            <td>{{$l['id']}}</td>
            <td>{{$l['obtainedresult']}}</td>
            <td>{{$l['level']}}</td>
            <td>
                <a href="/showCalcWaga/{{$l['id']}}"><button>Pokaż wagę</button></a>&nbsp;

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4"> - Brak Obliczeń -</td>
        </tr>
        @endforelse
    </table>



    </table>
</div>

@endsection('content')