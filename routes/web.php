<?php

use Illuminate\Support\Facades\Route;

Route::match(["get", "post"], '/', "App\Http\Controllers\MainController@list" );


// Route::match(["get", "post"], 'area/calc/{id}', "App\Http\Controllers\MainController@calcarea" );
Route::match(["get", "post"], 'area/calc_level2/{id}/{lvl}', "App\Http\Controllers\MainController@calcarea_level" );

Route::match(["get", "post"], 'diamond/{id}/{lvl}/{dId}', "App\Http\Controllers\MainController@calcarea_level" );

Route::get('area/showpercent/{id}',  "App\Http\Controllers\MainController@percentshow" );
Route::get('area/histogram/{id}',  "App\Http\Controllers\MainController@histogram" );
Route::get('mutations',  "App\Http\Controllers\MainController@mutations" );
Route::get('samecalculations',  "App\Http\Controllers\MainController@samecalculations" );

Route::get('diamon/add/{id}',  "App\Http\Controllers\MainController@adddiamond" );

 