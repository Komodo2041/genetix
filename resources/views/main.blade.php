@extends('template')
@section('content')

<h3>Powierzchnie do sprawdzania</h3>
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
            <td>
              <h4>All: {{$a?->calculations->count()}} </h4> 
              @foreach ($calco[$a->id] AS $c) 
                 {{$c["level"]}} : {{$c["count"]}} : {{$c["max"]}} <br/>
              @endforeach
            </td>
            <td> 
                  <a href="/area/calc/{{$a->id}}">Dokonaj obliczeń obszaru - poziom 1</a><br/>

                  @foreach ($calco[$a->id] AS $c) 
                      @if  ($c['count'] >= 10)
                      <a href="/area/calc_level2/{{$a->id}}/{{$c['level'] + 1}}">Dokonaj obliczeń obszaru - poziom  {{$c["level"] + 1}}</a><br/>
                      @endif
                  @endforeach
 
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