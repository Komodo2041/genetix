@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<h3>Matryca siły - Area {{$area->id}}</h3>
<h4>Power: {{$power}}</h4>    

@foreach ($res AS $lvl => $record)
   <p class="backo">Level :  {{$lvl}} -  Diff {{$lvlinfo[$lvl]}}</p>
   <table>
       <tr>
           <th>Result</th>
           <th>Power</th>
           <th>Diff</th>
       </tr>
    @foreach ($record AS $r)
       <tr>
           <td>{{$r['result']}}</td>
           <td>{{$r['power']}}</td>
           <td>{{$r['diff']}}</td>         
       </tr>
    @endforeach
</table>
@endforeach
 

@endsection('content')