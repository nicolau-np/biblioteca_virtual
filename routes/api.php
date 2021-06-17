<?php


use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>"leitors", ], function(){
    Route::get('/', "LeitorController@index");
    Route::get('/show/{id}', "LeitorController@show");
    Route::post('/store', "LeitorController@store");
    Route::put('/update/{id}', "LeitorController@update");
    Route::delete('/destroy/{id}', "LeitorController@destroy");
});

Route::group(['prefix'=>"autors", ], function(){
    Route::get('/', "AutorController@index");
    Route::get('/show/{id}', "AutorController@show");
    Route::post('/store', "AutorController@store");
    Route::put('/update/{id}', "AutorController@update");
    Route::delete('/destroy/{id}', "AutorController@destroy");
});

Route::group(['prefix'=>"editoras", ], function(){
    Route::get('/', "EditoraController@index");
    Route::get('/show/{id}', "EditoraController@show");
    Route::post('/store', "EditoraController@store");
    Route::put('/update/{id}', "EditoraController@update");
    Route::delete('/destroy/{id}', "EditoraController@destroy");
});

Route::group(['prefix'=>"categoria_livros", ], function(){
    Route::get('/', "CategorialivroController@index");
    Route::get('/show/{id}', "CategorialivroController@show");
    Route::post('/store', "CategorialivroController@store");
    Route::put('/update/{id}', "CategorialivroController@update");
    Route::delete('/destroy/{id}', "CategorialivroController@destroy");
});

Route::group(['prefix'=>"tipo_pedidos", ], function(){
    Route::get('/', "TipopedidoController@index");
    Route::get('/show/{id}', "TipopedidoController@show");
    Route::post('/store', "TipopedidoController@store");
    Route::put('/update/{id}', "TipopedidoController@update");
    Route::delete('/destroy/{id}', "TipopedidoController@destroy");
});

Route::group(['prefix'=>"users"], function(){
    Route::get('/', "AuthController@index");
    Route::post('/register', "AuthController@register");
});