<?php

use Illuminate\Support\Facades\Route;

Route::match(["get", "post"], '/', "App\Http\Controllers\AreaController@list");
Route::get('hidearea/{id}',  "App\Http\Controllers\AreaController@hide");
Route::get('changeFlex/{id}/{tr}',  "App\Http\Controllers\AreaController@changeFlex");

Route::match(["get", "post"], 'area/calc_level2/{id}/{lvl}', "App\Http\Controllers\MainController@calcarea_level");
Route::match(["get", "post"], 'diamond/{id}/{lvl}/{dId}', "App\Http\Controllers\MainController@calcarea_level");
Route::get('calcareamoretimes/{id}/{trybe}',  "App\Http\Controllers\MainController@calcareamoretimes");

Route::get('powermatrix/{size}',  "App\Http\Controllers\PowerController@showmatrix");
Route::get('calcpowermatrix/{size}',  "App\Http\Controllers\PowerController@calcpowermatrix");
Route::get('showpower/{id}',  "App\Http\Controllers\PowerController@showpower");
Route::get('see10Layerpower/{size}',  "App\Http\Controllers\PowerController@see10Layerpower");
Route::get('show5Result/{id}',  "App\Http\Controllers\PowerController@show5Result");
Route::get('show50Result/{id}',  "App\Http\Controllers\PowerController@show50Result");
Route::get('show50Result/{id}/{nr}',  "App\Http\Controllers\PowerController@show50Result");

Route::get('showavgcalculations/{id}',  "App\Http\Controllers\AvgController@showavgcalculations");
Route::get('calcAvgforArea/{id}/{part}',  "App\Http\Controllers\AvgController@calcAvgforArea");
Route::get('desilting/{id}',  "App\Http\Controllers\AvgController@desilting");

Route::get('mutations',  "App\Http\Controllers\CheckingCrossAndMutation@mutations");
Route::get('calcMatrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@calcMatrix");
Route::get('calcMatrix/{id}/{nrM}',  "App\Http\Controllers\CheckingCrossAndMutation@calcMatrix");
Route::get('calcCrossMatrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutationr@calcCrossMatrix");
Route::get('showCrossMatrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@showCrossMatrix");
Route::get('calcCrossMatrix/{id}/{nrM}',  "App\Http\Controllers\CheckingCrossAndMutation@calcCrossMatrix");
Route::get('showMatrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@showMatrix");
Route::get('calcAllPowerSelect/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@calcAllPowerSelect");
Route::get('showPowerSelect/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@showPowerSelect");
Route::get('turn_matrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@turnMatrix");
Route::get('turnoff_matrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@turnoffMatrix");
Route::get('turnofftwo_matrix/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@turnofftwoMatrix");
Route::get('setmatrixcross/{id}/{val}',  "App\Http\Controllers\CheckingCrossAndMutation@setmatrixcross");
Route::get('showPowerBigLayer/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@showPowerBigLayer");
Route::get('calcPowerBigLayer/{id}/{nrM}',  "App\Http\Controllers\CheckingCrossAndMutation@calcPowerBigLayer");
Route::get('showBigMutationLayer/{id}/{tryb}',  "App\Http\Controllers\CheckingCrossAndMutation@showBigMutationLayer");
Route::get('calcBigMutationLayer/{id}/{tryb}/{nrM}',  "App\Http\Controllers\CheckingCrossAndMutation@calcBigMutationLayer");
Route::get('calcOneMutation/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@calcOneMutation");
Route::post('calcOneMutation/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@calcOneMutation");
Route::get('calcOneCrossing/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@calcOneCrossing");
Route::post('calcOneCrossing/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@calcOneCrossing");
Route::get('random50Multiple/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@random50Multiple");
Route::get('showrandom50Multiple/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@showrandom50Multiple");
Route::get('random50MultipleTryb2/{id}',  "App\Http\Controllers\CheckingCrossAndMutation@random50MultipleTryb2");
Route::get('showrandom50Multiple/{id}/{param}',  "App\Http\Controllers\CheckingCrossAndMutation@showrandom50Multiple");

Route::get('calculations/{id}',  "App\Http\Controllers\CalcController2@list");
Route::get('/calculating/progress/{id}',  "App\Http\Controllers\CalcController2@showprocess");
Route::get('samecalculations/{id}',  "App\Http\Controllers\CalcController2@samecalculations");
Route::get('showselectigcalculations/{id}',  "App\Http\Controllers\CalcController2@showselectigcalculations");
Route::get('onecalculation/{id}',  "App\Http\Controllers\CalcController2@onecalculation");
Route::get('bottomLastLayer/{id}',  "App\Http\Controllers\CalcController2@bottomLastLayer");
Route::get('area/usedmethods/{id}',  "App\Http\Controllers\CalcController2@usedmethods");
Route::get('area/deleteSameCalc/{id}',  "App\Http\Controllers\CalcController2@deleteSameCalc");
Route::get('showerror/{id}',  "App\Http\Controllers\CalcController2@showerros");
Route::get('showring/{id}',  "App\Http\Controllers\CalcController2@showring");
Route::get('area/histogram/{id}',  "App\Http\Controllers\CalcController2@histogram");
Route::get('calcallavg/{id}',  "App\Http\Controllers\CalcController2@calcallavg");
Route::get('area/showpercent/{id}',  "App\Http\Controllers\CalcController2@percentshow");
Route::get('goPomCalculating/{id}',  "App\Http\Controllers\CalcController2@goPomCalculating");
Route::get('bigcrossingtwocalc/{id}',  "App\Http\Controllers\CalcController2@bigcrossingtwocalc");
Route::get('crossingOneLevel/{id}',  "App\Http\Controllers\CalcController2@crossingOneLevel");
Route::get('spirallMutation/{id}',  "App\Http\Controllers\CalcController2@spirallMutation");
Route::get('calcRabbit/{id}',  "App\Http\Controllers\CalcController2@calcRabbit");
Route::get('diffbestCalculation/{id}',  "App\Http\Controllers\CalcController2@diffbestCalculation");


Route::get('showgeneration0/{id}/{dimension}',  "App\Http\Controllers\Gen0Controller@showgeneration0");
Route::get('calcGeneration0/{id}/{tryb}/{dimension}',  "App\Http\Controllers\Gen0Controller@calcGeneration0");
Route::get('calcAltgeneration0/{id}/{dimension}',  "App\Http\Controllers\Gen0Controller@calcAltGen0");
Route::get('calc3DimGen0/{id}',  "App\Http\Controllers\Gen0Controller@calc3DimGen0");
Route::get('calcUp50OneGen0/{id}/{upDown}',  "App\Http\Controllers\Gen0Controller@calcUp50OneGen0");
Route::get('calcUp50OneGen0/{id}/{upDown}/{gen0Id}',  "App\Http\Controllers\Gen0Controller@calcUp50OneGen0");
Route::get('advancedgen0/{id}',  "App\Http\Controllers\Gen0Controller@advancedGen0");
Route::get('advancedgen0/{id}/{tryb}',  "App\Http\Controllers\Gen0Controller@advancedGen0");
Route::get('calcAdvGen0/{gid}/{stere}',  "App\Http\Controllers\Gen0Controller@calcAdvGen0");
Route::get('calcAdvGen0/{gid}/{stere}/{who}',  "App\Http\Controllers\Gen0Controller@calcAdvGen0");
Route::get('helpgeneration0/{id}/{dimension}',  "App\Http\Controllers\Gen0Controller@helpshowgeneration0");
Route::get('showUpDownGen0Calc/{gid}',  "App\Http\Controllers\Gen0Controller@showUpDownGen0Calc");
Route::get('showUpDownGen0Calc/{gid}/{tryb}',  "App\Http\Controllers\Gen0Controller@showUpDownGen0Calc");

Route::get('cloneRiver/{id}',  "App\Http\Controllers\RiverController@cloneRiver");
Route::get('showRiver/{id}',  "App\Http\Controllers\RiverController@showRiver");
Route::get('pourRiver/{id}',  "App\Http\Controllers\RiverController@pourRiver");
Route::get('addRiver/{id}',  "App\Http\Controllers\RiverController@addRiver");
Route::get('riverSettings/{id}',  "App\Http\Controllers\RiverController@riverSettings");
Route::post('river/changeName/{id}',  "App\Http\Controllers\RiverController@changeName");
Route::post('river/settingGen0Box/{id}',  "App\Http\Controllers\RiverController@settingGen0Box");
Route::get('addTama/{id}',  "App\Http\Controllers\RiverController@addTama");
Route::get('addRabbit/{id}',  "App\Http\Controllers\RiverController@addRabbit");


Route::get('diamon/add/{id}',  "App\Http\Controllers\DiamondController@adddiamond");

Route::get('createweighingscale/{id}',  "App\Http\Controllers\WagaController@createweighingscale");
Route::get('showwagainArea/{id}',  "App\Http\Controllers\WagaController@shoWagainArea");
Route::get('showCalcWaga/{id}',  "App\Http\Controllers\WagaController@showCalcWaga");


Route::get('showCron',  "App\Http\Controllers\CronController@show");
Route::post('showCron',  "App\Http\Controllers\CronController@show");
Route::post('cron/setOneCalc',  "App\Http\Controllers\CronController@setOneCalc");


Route::get('showCalcSame/{id}',  "App\Http\Controllers\SameCalcController@show");
Route::get('compareCalculations/{id}',  "App\Http\Controllers\SameCalcController@compare");
Route::get('checkBlob/{id}/{tryb}',  "App\Http\Controllers\SameCalcController@checkBlob");
Route::get('compareGen0/{id}/{count}',  "App\Http\Controllers\SameCalcController@compareGen0");
Route::post('setRiverGen0/{id}',  "App\Http\Controllers\SameCalcController@setRiverGen0");

Route::get('joiner50List/{id}',  "App\Http\Controllers\Joiner50Controller@list");
Route::get('showSpecialJoin/{id}/{join}',  "App\Http\Controllers\Joiner50Controller@showjoin");
