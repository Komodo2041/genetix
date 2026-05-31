<?php

use Illuminate\Support\Facades\Route;

Route::match(["get", "post"], '/', "App\Http\Controllers\AreaController@list" );
Route::get('hidearea/{id}',  "App\Http\Controllers\AreaController@hide" ); 
Route::get('changeFlex/{id}/{tr}',  "App\Http\Controllers\AreaController@changeFlex" );

Route::match(["get", "post"], 'area/calc_level2/{id}/{lvl}', "App\Http\Controllers\MainController@calcarea_level" );
Route::match(["get", "post"], 'diamond/{id}/{lvl}/{dId}', "App\Http\Controllers\MainController@calcarea_level" );
Route::get('createweighingscale/{id}',  "App\Http\Controllers\MainController@createweighingscale" );
Route::get('calcareamoretimes/{id}/{trybe}',  "App\Http\Controllers\MainController@calcareamoretimes" );
 
Route::get('powermatrix/{size}',  "App\Http\Controllers\PowerController@showmatrix" );
Route::get('calcpowermatrix/{size}',  "App\Http\Controllers\PowerController@calcpowermatrix" ); 
Route::get('showpower/{id}',  "App\Http\Controllers\PowerController@showpower" );
Route::get('see10Layerpower/{size}',  "App\Http\Controllers\PowerController@see10Layerpower" ); 
Route::get('show5Result/{id}',  "App\Http\Controllers\PowerController@show5Result" ); 
   
Route::get('showavgcalculations/{id}',  "App\Http\Controllers\AvgController@showavgcalculations" );
Route::get('calcAvgforArea/{id}/{part}',  "App\Http\Controllers\AvgController@calcAvgforArea" );
Route::get('desilting/{id}',  "App\Http\Controllers\AvgController@desilting" );

Route::get('mutations',  "App\Http\Controllers\CheckingCrossAndMutation@mutations" );
Route::get('calcMatrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@calcMatrix" );
Route::get('calcMatrix/{id}/{nrM}',  "App\Http\Controllers\CheckingCrossAndMutation@calcMatrix" ); 
Route::get('calcCrossMatrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutationr@calcCrossMatrix" );
Route::get('showCrossMatrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@showCrossMatrix" ); 
Route::get('calcCrossMatrix/{id}/{nrM}',  "App\Http\Controllers\CheckingCrossAndMutation@calcCrossMatrix" );
Route::get('showMatrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@showMatrix" );
Route::get('calcAllPowerSelect/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@calcAllPowerSelect" ); 
Route::get('showPowerSelect/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@showPowerSelect" );
 Route::get('turn_matrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@turnMatrix" ); 
Route::get('turnoff_matrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@turnoffMatrix" ); 
Route::get('turnofftwo_matrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@turnofftwoMatrix" );
Route::get('setmatrixcross/{id}/{val}',  "App\Http\Controllers\CheckingCrossAndMutation@setmatrixcross" ); 
Route::get('showPowerBigLayer/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@showPowerBigLayer" );
Route::get('calcPowerBigLayer/{id}/{nrM}',  "App\Http\Controllers\CheckingCrossAndMutation@calcPowerBigLayer" );
Route::get('showBigMutationLayer/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@showBigMutationLayer" );
Route::get('calcBigMutationLayer/{id}/{nrM}',  "App\Http\Controllers\CheckingCrossAndMutation@calcBigMutationLayer" );

Route::get('calculations/{id}',  "App\Http\Controllers\CalcController@list" );
Route::get('/calculating/progress/{id}',  "App\Http\Controllers\CalcController@showprocess" );
Route::get('samecalculations/{id}',  "App\Http\Controllers\CalcController@samecalculations" );
Route::get('showselectigcalculations/{id}',  "App\Http\Controllers\CalcController@showselectigcalculations" );
Route::get('onecalculation/{id}',  "App\Http\Controllers\CalcController@onecalculation" );
Route::get('bottomLastLayer/{id}',  "App\Http\Controllers\CalcController@bottomLastLayer" );
Route::get('area/usedmethods/{id}',  "App\Http\Controllers\CalcController@usedmethods" );
Route::get('area/deleteSameCalc/{id}',  "App\Http\Controllers\CalcController@deleteSameCalc" );
Route::get('showerror/{id}',  "App\Http\Controllers\CalcController@showerros" );
Route::get('showring/{id}',  "App\Http\Controllers\CalcController@showring" );
Route::get('area/histogram/{id}',  "App\Http\Controllers\CalcController@histogram" );
Route::get('calcallavg/{id}',  "App\Http\Controllers\CalcController@calcallavg" );
Route::get('area/showpercent/{id}',  "App\Http\Controllers\CalcController@percentshow" );

Route::get('cloneRiver/{id}',  "App\Http\Controllers\RiverController@cloneRiver" );
Route::get('showRiver/{id}',  "App\Http\Controllers\RiverController@showRiver" );
Route::get('pourRiver/{id}',  "App\Http\Controllers\RiverController@pourRiver" );
Route::get('addRiver/{id}',  "App\Http\Controllers\RiverController@addRiver" );

Route::get('diamon/add/{id}',  "App\Http\Controllers\DiamondController@adddiamond" );