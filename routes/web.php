<?php

use Illuminate\Support\Facades\Route;

Route::match(["get", "post"], '/', "App\Http\Controllers\MainController@list" );
