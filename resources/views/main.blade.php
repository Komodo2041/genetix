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
              <h4>{{$a?->calculations->count()}} </h4> 
 
            </td>
            <td> 
                  <a href="/area/calc/{{$a->id}}">Dokonaj obliczeń obszaru - poziom 1</a><br/>

                  <a href="/area/calc_level2/{{$a->id}}/2">Dokonaj obliczeń obszaru - poziom 2</a><br/>
                  <a href="/area/calc_level2/{{$a->id}}/3">Dokonaj obliczeń obszaru - poziom 3</a><br/>
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