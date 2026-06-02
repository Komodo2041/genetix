@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>
<a href="/showMatrix/{{$area->id}}"><button>Matrix Wszystkich Mutacji</button></a>&nbsp;

<h3>Jedna Mutacja {{$area->name}}</h3>
<div class="container">
   <form action="" method="post">
        @csrf
        <label>Mutacje</label>
        <select name="method">
            @foreach ($methods AS $m)
               <option value="{{$m}}">{{$m}}</option>
            @endforeach
        </select>    
        <input type="submit" value="Oblicz" />
    </form>
 

  
</div>

@endsection('content')