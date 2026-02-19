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
   <tr>
      <td>{{$res[2][$x]}}</td>
      <td>{{$res2[2][$x]}}</td>
   </tr>
 <table>

</div>
@endforeach



<h4 class="hpen">Poziomo</h4>
@foreach ($calc AS $x => $table) 
<div class="totable">
   <table class="level">
   @foreach ($table AS $y => $row)
      <tr>
      @foreach ($row AS $z => $val)
         <td @if ($calc[$z][$x][$y]) class="red" @endif>
            
         </td>
      @endforeach 
      </tr>
   @endforeach
</table>

   <table class="level">
   @foreach ($table AS $y => $row)
      <tr>
      @foreach ($row AS $z => $val)
         <td @if ($area[$z][$x][$y]) class="red" @endif>
            
         </td>
      @endforeach 
      </tr>
   @endforeach
</table>

   <table class="level">
   @foreach ($table AS $y => $row)
      <tr>
      @foreach ($row AS $z => $val)
         <td @if ($area[$z][$x][$y] != $calc[$z][$x][$y]) class="red" @endif>
            
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
   <tr>
      <td>{{$res[1][$x]}}</td>
      <td>{{$res2[1][$x]}}</td>
   </tr>
 <table>

</div>
@endforeach


<h4 class="hpen">Poziomo 2</h4>
@foreach ($calc AS $x => $table) 
<div class="totable">
   <table class="level">
   @foreach ($table AS $y => $row)
      <tr>
      @foreach ($row AS $z => $val)
         <td @if ($calc[$x][$z][$y]) class="red" @endif>
            
         </td>
      @endforeach 
      </tr>
   @endforeach
</table>

   <table class="level">
   @foreach ($table AS $y => $row)
      <tr>
      @foreach ($row AS $z => $val)
         <td @if ($area[$x][$z][$y]) class="red" @endif>
            
         </td>
      @endforeach 
      </tr>
   @endforeach
</table>

   <table class="level">
   @foreach ($table AS $y => $row)
      <tr>
      @foreach ($row AS $z => $val)
         <td @if ($area[$x][$z][$y] != $calc[$x][$z][$y]) class="red" @endif>
            
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
   <tr>
      <td>{{$res[0][$x]}}</td>
      <td>{{$res2[0][$x]}}</td>
   </tr>
 <table>

</div>
@endforeach

  
</div>

@endsection('content')