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
      @forelse ($area AS $a)
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
                  <a href="/area/usedmethods/{{$a->id}}"><button>Początkowe populacje</button></a>&nbsp;

                  @if (is_null($a->river))
                     <a href="/addRiver/{{$a->id}}"><button>Dodaj rzekę</button></a>&nbsp;
                     <a href="/showRiver/{{$a->id}}"><button>Pokaż wyniki rzek</button></a>&nbsp;
                  @else
                     <a href="/pourRiver/{{$a->id}}"><button>Wlej rzekę</button></a>&nbsp;
                     <a href="/cloneRiver/{{$a->id}}"><button>Klonuj rzekę</button></a>&nbsp;
                  @endif

                  <a href="/calcMatrix/{{$a->id}}"><button>Aktualizuj Matryce Mutacji</button></a>&nbsp;
                  <a href="/showMatrix/{{$a->id}}"><button>Pokaż Matryce Mutacji</button></a>&nbsp;

                  <a href="/calcCrossMatrix/{{$a->id}}"><button>Oblicz Matryce Krzyżowań</button></a>&nbsp;
                  <a href="/showCrossMatrix/{{$a->id}}"><button>Pokaż Matryce Krzyżowań</button></a>&nbsp;

                  @if ($a->matrixtribe == 0) 
                     <a href="/turn_matrix/{{$a->id}}"><button>Włącz używany matrycy</button></a>  
                  @elseif ($a->matrixtribe == 2)   
                     <a href="/turnoff_matrix/{{$a->id}}"><button class="secondary">Wyłącz uzywanie matrycy</button></a>
                  @else ($a->matrixtribe == 1)   
                     <a href="/turnofftwo_matrix/{{$a->id}}"><button>Włącz matrycę tylko dla najlepszych mutacji</button></a>                      
                  @endif   

                  <a href="/createweighingscale/{{$a->id}}"><button>Twórz wagę</button></a> 


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
        @empty
        <tr>
           <td colspan="3" class="td_i">Brak Obszarów do obliczeń</td>
        </tr>  
      @endforelse
</table>

     
   <form action="" id="formarea" method="Post">
     @csrf
     <input type="hidden" value="1" name="save" />
     <input type="submit" name="action" value="Dodaj test Dno morza" />
     <input type="submit" name="action" value="Dodaj obszar 0 i 1" />
     <input type="submit" name="action" value="Dodaj przekladaniec Z" />
     <input type="submit" name="action" value="Dodaj przekladaniec X" />
     <input type="submit" name="action" value="Dodaj przekladaniec Y" />
     <input type="submit" name="action" value="Generuj jaskinie" />
     <input type="submit" name="action" value="3 różne warstwy Z" />
      
     </form>  
</div>

@endsection('content')