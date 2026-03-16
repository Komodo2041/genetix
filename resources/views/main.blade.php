@extends('template')
@section('content')

<h3>Powierzchnie do sprawdzania</h3>

<a href="/mutations"><button>Mutacje - Krzyżowania</button></a> 
<a href="/samecalculations"><button>Znajdź podobne obliczenia</button></a><br/>

 
<div class="container">
    
   <table>
      <tr>
         <th>Nazwa</th>
         <th>Wynik</th>
         <th>Opcje</th>
      </tr>
      @foreach ($area AS $a)
        <tr>
            <td>{{$a->name}}</td>
            <td style="width:400px;">
              <h4>All: {{$a?->calculations->count()}} </h4> 
              @if (isset($calco[$a->id]))
                @foreach ($calco[$a->id] AS $c) 
                    Level : {{$c["level"]}} - ALL : {{$c["count"]}}<br/>                  
                    MAX : {{$c["max"]}} <br/>
                    AVG : {{$c["avg"]}} <br/><br/>
                @endforeach
              @endif  
            </td>
            <td> 
                  <a href="/calcallavg/{{$a->id}}" ><button>Przelicz średnie dla poziomów</button></a>
                  <a href="/area/showpercent/{{$a->id}}"><button>Pokaż procenty dopasowania</button></a> &nbsp;
                  <a href="/area/histogram/{{$a->id}}"><button>Histogram</button></a>&nbsp;
                  @if (is_null($a->river))
                     <a href="/addRiver/{{$a->id}}"><button>Dodaj rzekę</button></a>&nbsp;
                     <a href="/showRiver/{{$a->id}}"><button>Pokaż wyniki rzek</button></a>&nbsp;
                  @else
                     <a href="/pourRiver/{{$a->id}}"><button>Wlej rzekę</button></a>&nbsp;
                     <a href="/cloneRiver/{{$a->id}}"><button>Klonuj rzekę</button></a>&nbsp;
                  @endif
                  <a href="/hidearea/{{$a->id}}"><button>Ukryj</button></a><br/>
                 
                   <br/>
                  @foreach ($a->diamonds AS $d)
                       <a href="diamond/{{$a->id}}/{{ count($calco[$a->id]) - 1 }}/{{$d->id}}"><button>Oblicz Diament {{$d->id}}</button></a>     
                  @endforeach
                  <br/>
                  <a href="/area/calc_level2/{{$a->id}}/1">Dokonaj obliczeń obszaru - poziom 1</a><br/>
                  @if (isset($calco[$a->id]))
                    @foreach ($calco[$a->id] AS $c) 
                        @if  ($c['count'] >= 10)
                        <a href="/area/calc_level2/{{$a->id}}/{{$c['level'] + 1}}">Dokonaj obliczeń obszaru - poziom  {{$c["level"] + 1}}</a><br/>
                        @endif
                    @endforeach
                  @endif
            </td>
        </tr>
      @endforeach
</table>

     
   <form action="" method="Post">
     @csrf
     <input type="hidden" value="1" name="save" />
     <input type="submit" name="action" value="Dodaj test Dno morza" />
     <input type="submit" name="action" value="Dodaj obszar 0 i 1" />

      
     </form>  
</div>

@endsection('content')