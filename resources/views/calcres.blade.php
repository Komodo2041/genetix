@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<h3>Obliczenia dla {{$area->name}} - {{$area->id}}</h3>
<div class="container">
 

   
   <table>
      <tr>
         <th>Id</th>
         <th>Level</th>
         <th>Result</th> 
         <th></th>
      </tr>
      @foreach ($calco AS $p) 
        <tr>
            <td>#{{$p['id']}}</td>
            <td>{{$p['level']}}</td>
            <td>{{$p['obtainedresult']}}</td> 
            <td>
               <a href="/calculating/progress/{{$p['id']}}" ><button>Pokaż postęp</button></a>           
            </td>
        </tr>
      @endforeach
</table>

  
</div>

@endsection('content')