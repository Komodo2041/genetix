<?php

use Illuminate\Support\Facades\Route;

Route::match(["get", "post"], '/', "App\Http\Controllers\MainController@list" );


// Route::match(["get", "post"], 'area/calc/{id}', "App\Http\Controllers\MainController@calcarea" );
Route::match(["get", "post"], 'area/calc_level2/{id}/{lvl}', "App\Http\Controllers\MainController@calcarea_level" );