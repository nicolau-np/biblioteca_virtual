<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>"leitors", ], function(){
    Route::get('/', "LeitorController@index");
    Route::get('/show/{id}', "LeitorController@show");
    Route::post('/store', "LeitorController@store");
    Route::put('/update/{id}', "LeitorController@update");
    Route::delete('/destroy/{id}', "LeitorController@destroy");
});