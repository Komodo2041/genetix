@extends('template')
@section('content')

<a href="/"><button>Strona główna</button></a><br/>

<h3>Różnice</h3>
<div class="container">
 
<h4>Pionowo</h4>
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
 

</div>
@endforeach



<h4>Poziomo</h4>
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
 

</div>
@endforeach
  
</div>

@endsection('content')