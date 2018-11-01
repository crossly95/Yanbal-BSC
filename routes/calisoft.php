<?php
Route::prefix('/perfil')->group(function () {
    Route::get('/', 'PerfilController@index')->name('perfil.index');
    Route::post('/', 'PerfilController@update')->name('perfil.update');
    Route::post('password', 'PerfilController@updatePassword')->name('perfil.password');
    Route::post('foto', 'PerfilController@fotoUp')->name('perfil.foto');
});


Route::get('porcentajes', 'UserController@porcentajes')->name('porcentajes');
Route::get('porcentajesbd', 'UserController@porcentajesBD')->name('porcentajesbd');

Route::get('/estandar-codificacion','UserController@estandaresCodificacion')
->name('estandar-codificacion');

Route::get('/estandar-basedatos','UserController@estandaresBasedatos')
->name('estandar-basedatos');

Route::get('porcentajesCodificacion', 'UserController@porcentajesCodificacion')->name('porcentajesCod');


Route::get('/notificaciones', 'NotificationController@vista')->name('notificaciones');



Route::prefix('pdf')->group(function () {

    Route::post('usuarios', 'PDFController@usuarios')->name('pdf.usuarios');
    Route::post('proyecto/{proyecto}/modelacion', 'PDFController@modelacion')->name('pdf.modelacion');
    Route::post('proyecto/{proyecto}/codificacion', 'PDFController@scripts')->name('pdf.scripts');
    Route::post('proyecto/{proyecto}/basedatos','PDFController@basedatos')->name('pdf.basedatos');
    Route::post('proyecto/{proyecto}/plataforma', 'PDFController@plataforma')->name('pdf.plataforma');
    Route::post('proyecto/{proyecto}/total', 'PDFController@total')->name('pdf.total');
    Route::post('usuariosRrhh/{usuario}/resultados/res', 'PDFController@resultados')->name('pdf.resultados');
});
