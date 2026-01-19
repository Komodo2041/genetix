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
            <td></td>
            <td>

 
                  <a href="/area/calc/{{$a->id}}">Punkty do Obliczeń</a>
            </td>
        </tr>
      @endforeach
</table>

     
   <form action="" method="Post">
     @csrf
     <input type="hidden" value="1" name="save" />
     <input type="submit" name="action" value="Dodaj test Dno morza" />
     </form>  
</div>

@endsection('content')