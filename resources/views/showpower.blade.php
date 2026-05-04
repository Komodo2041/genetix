@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<h3>Matryca siły - Area {{$area->id}}</h3>
<h4>Power: {{$power}}</h4>    

@foreach ($res AS $lvl => $record)
   <p class="backo">Level :  {{$lvl}} -  Diff {{$lvlinfo[$lvl]['diff']}}  - AVG {{$lvlinfo[$lvl]['avg']}} | DIFFAVG: {{$lvlinfo[$lvl]['diffavg']}} </p>
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
 
<table>

<h4>Levele</h4>
@foreach ($res AS $lvl => $record)
     <tr>
         <td>{{$lvl}}</td>
         <td>{{$lvlinfo[$lvl]['diff']}}</td>
     </tr>
 
@endforeach
</table>


@endsection('content')