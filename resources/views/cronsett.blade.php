@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>
 

<h3>Ustawienia Cronów</h3>
<div class="container">
   <form action="" method="POST"> 
        @csrf;
        <table>
         <tr>
           <th>Nazwa</th>
           <th>Tryb 0 <br/>MAKS</th> 
           <th>Tryb 1<br/>4 Last</th> 
           <th>Tryb 2<br/>Next</th> 
           <th>Tryb 3<br/>All lvl</th> 
           <th>Tryb 4<br/>{1 lvl}</th>  
           <th>Tryb 5<br/>{3 lvl}</th>     
       </tr> 
          @foreach ($areas AS $a)
             <tr>
                <td>{{$a->name}} :  {{$a->id}}</td>
                <td><input name="sett[{{$a->id}}][0]" value="1" type="checkbox" @if (isset($sett[$a->id][0])) checked @endif /></td>
                <td><input name="sett[{{$a->id}}][1]" value="1" type="checkbox" @if (isset($sett[$a->id][1])) checked @endif /></td>
                <td><input name="sett[{{$a->id}}][2]" value="1" type="checkbox" @if (isset($sett[$a->id][2])) checked @endif /></td>
                <td><input name="sett[{{$a->id}}][3]" value="1" type="checkbox" @if (isset($sett[$a->id][3])) checked @endif /></td>
                <td><input name="sett[{{$a->id}}][4]" value="1" type="checkbox" @if (isset($sett[$a->id][4])) checked @endif /></td>
                <td><input name="sett[{{$a->id}}][5]" value="1" type="checkbox" @if (isset($sett[$a->id][5])) checked @endif /></td> 
             </tr>   
          @endforeach
         </table>

      <input type="submit" value="Zmień" name="submit" />
    </form>
 
</div>
<h3>Pojedyńcze Obliczenie Cron</h3>
<div class="container">
   <form action="/cron/setOneCalc" method="POST"> 
        @csrf;
        <table>
         <tr>
           <th>Nazwa</th>
           <th> </th>      
       </tr> 
          @foreach ($areas AS $a)
             <tr>
                <td>{{$a->name}} :  {{$a->id}}</td>
                <td><input name="sett2[{{$a->id}}]" value="1" type="checkbox" @if ($sett2[$a->id] == 1) checked @endif /></td>
             </tr>   
          @endforeach
         </table>

      <input type="submit" value="Zmień" name="submit" />
    </form>
 
</div>


@endsection('content')