@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a>
<a href="/showRiver/{{$area->id}}"><button>Pokaż wyniki rzek</button></a><br/>
<br/>

<h3>Rzeki</h3>
<div class="container">
 

   
   <table>
      <tr>
         <th>Nazwa</th>
         <th>Opcje</th>
         <th>Zmień Nazwę</th>
      </tr>
      @foreach ($areas AS $a) 
        <tr>
            <td>{{$a->id}} - {{$a->name}}</td> 
            <td>
                <a href="/pourRiver/{{$a->id}}"><button>Wlej rzekę</button></a>&nbsp;
                <a href="/cloneRiver/{{$a->id}}"><button>Klonuj rzekę</button></a>&nbsp; 
            </td>
            <td>
                <form action="/river/changeName/{{$a->id}}" method="POST">
                    @csrf;
                    <input type="text" name="title" value="{{$a->name}}" />
                    <input type="submit" name="sub"  value="Zmień" />
                </form>   
            </td>
        </tr> 
      @endforeach
</table>

  
</div>

@endsection('content')