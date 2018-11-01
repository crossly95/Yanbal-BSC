<?php

//Evaluaciones de documentacion
Route::resource('evaluaciones', 'DocumentEvalController', [
    'only' => ['show', 'update'],
    'parameters' => [
        'evaluaciones' => 'documento'
    ]
]);
//evaluaciones de scripts
Route::resource('evaluacionesScript','NotaScriptController',[
    'only' => ['show', 'update'],
    'parameters' => [
        'evaluacionesScript' => 'script'
    ]
]);

Route::resource('itemsEvaluados','ItemsEvaluadosController',[
     'only' => ['show','store'],
     'parameters' => [
         'itemsEvaluados' => 'item'
     ] 
]);

//evaluaciones de componentes sql
Route::resource('evaluacionSql','NotaFileBDController',[
    'only' => ['show', 'update'],
    'parameters' => [
        'evaluacionSql' => 'sql'
    ]
]);

// Obtiene la informacion de inicio de prueba
Route::post('testing', 'TestingController@testing');
Route::post('testing/save/{caso}', 'TestingController@guardar');

//GASFENOSA

Route::resource('usuariosRrhh', 'UsuariosRrhhController', [
    'only' => ['index','show','store', 'update']
]);

//Pruebas de respuetsas indicador

Route::resource('pruebas', 'PruebasController', [
    'only' => ['index', 'store', 'update', 'destroy','show'],
]);