<?php

use Illuminate\Support\Facades\Route;

Route::match(["get", "post"], '/', "App\Http\Controllers\MainController@list" );


// Route::match(["get", "post"], 'area/calc/{id}', "App\Http\Controllers\MainController@calcarea" );
Route::match(["get", "post"], 'area/calc_level2/{id}/{lvl}', "App\Http\Controllers\MainController@calcarea_level" );

Route::match(["get", "post"], 'diamond/{id}/{lvl}/{dId}', "App\Http\Controllers\MainController@calcarea_level" );

Route::get('area/showpercent/{id}',  "App\Http\Controllers\MainController@percentshow" );
Route::get('area/histogram/{id}',  "App\Http\Controllers\MainController@histogram" );
Route::get('area/usedmethods/{id}',  "App\Http\Controllers\MainController@usedmethods" );
 
Route::get('mutations',  "App\Http\Controllers\MainController@mutations" );
Route::get('samecalculations',  "App\Http\Controllers\MainController@samecalculations" );

Route::get('diamon/add/{id}',  "App\Http\Controllers\MainController@adddiamond" );

Route::get('showerror/{id}',  "App\Http\Controllers\MainController@showerros" );
Route::get('showring/{id}',  "App\Http\Controllers\MainController@showring" );
Route::get('calcallavg/{id}',  "App\Http\Controllers\MainController@calcallavg" );

Route::get('addRiver/{id}',  "App\Http\Controllers\MainController@addRiver" );
Route::get('hidearea/{id}',  "App\Http\Controllers\MainController@hide" );

Route::get('pourRiver/{id}',  "App\Http\Controllers\MainController@pourRiver" );
Route::get('cloneRiver/{id}',  "App\Http\Controllers\MainController@cloneRiver" );

Route::get('showRiver/{id}',  "App\Http\Controllers\MainController@showRiver" ); 
Route::get('calcMatrix/{id}',  "App\Http\Controllers\MainController@calcMatrix" ); 
 
 
  