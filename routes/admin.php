<?php


Route::get('/semilleros', 'AdminController@semilleros')->name('semilleros');
Route::get('/categorias', 'AdminController@categorias')->name('categorias');
Route::get('/usuarios', 'AdminController@usuarios')->name('usuarios');
Route::get('/indicadores', 'AdminController@indicadores')->name('indicadores');
Route::get('/tdocumentos', 'AdminController@tipoDocumento')->name('tdocumentos');
Route::get('/proyecto', 'AdminController@proyectos')->name('proyecto.admin');
Route::get('/tdocumentos/{tdocumento}/componentes', 'AdminController@componentes')->name('componentes');
Route::get('/basedatos', 'AdminController@baseDatos')->name('basedatos');
Route::get('/codificacion','AdminController@codificacion')->name('codificacion');
Route::get('indicadores/{indicador}/planes', 'AdminController@planes')->name('preguntas.planes');
