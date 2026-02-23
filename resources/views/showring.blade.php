@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<h3>Różnice</h3>
<div class="container">
 
<h4 class="hpen">Pionowo</h4>
@foreach ($calc AS $x => $table) 
<div class="totable">
   <table class="level">
   @foreach ($table AS $y => $row)
      <tr>
      @foreach ($row AS $z => $val)
         <td @if ($calc[$z][$y][$x]) class="red" @endif>
            
         </td>
      @endforeach 
      </tr>
   @endforeach
</table>

   <table class="level">
   @foreach ($table AS $y => $row)
      <tr>
      @foreach ($row AS $z => $val)
         <td @if ($area[$z][$y][$x]) class="red" @endif>
            
         </td>
      @endforeach 
      </tr>
   @endforeach
</table>

   <table class="level">
   @foreach ($table AS $y => $row)
      <tr>
      @foreach ($row AS $z => $val)
         <td @if ($area[$z][$y][$x] != $calc[$z][$y][$x]) class="red" @endif>
            
         </td>
      @endforeach 
      </tr>
   @endforeach
</table>

 <table class="level-summary">
   <tr>
      <td>Wynik</td>
      <td>Wzór</td>
</tr>  
   @foreach ($res[$x] AS $key => $value)
    <tr>
        <td>{{ $res[$x][$key] }}</td>
        <td>{{ $res2[$x][$key] }}</td>
    </tr>
   @endforeach
 <table>

</div>
@endforeach

 

  
</div>

@endsection('content')