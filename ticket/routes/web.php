<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Route View

Auth::routes();

// Bagian API

Route::get('/api-ticket/{created_by}', 'apiController@show');

// Bagian Get

Route::get('back','ticketController@back');

Route::get('create','ticketController@create');

Route::get('delete/{id}','ticketController@delete');

Route::get('edit/{id}','ticketController@edit');

Route::get('read/{id}','ticketController@read');

Route::get('list', 'ticketController@index');

Route::get('admin', 'ticketController@admin');

Route::get('register', 'ticketController@register');

Route::get('Usrdelete/{id}','ticketController@Usrdelete');

Route::get('Usredit/{id}','ticketController@Usredit');

// Route::get('komentar','ticketController@komentar');


// Bagian Post

Route::post('insert', 'ticketController@insert');

Route::post('posting', 'ticketController@inskomentar');

Route::post('update/{id}', 'ticketController@update');

Route::post('register', 'ticketController@Usrinsert');

Route::post('Usrupdate/{id}', 'ticketController@Usrupdate');

Route::post('task_insert', 'ticketController@task_insert');

Route::post('task_update/{id}', 'ticketController@task_update');

// Bagian Task

Route::get('task', 'ticketController@task');

Route::get('task_create', 'ticketController@task_create');

Route::get('task_delete/{id}','ticketController@task_delete');

Route::get('task_edit/{id}','ticketController@task_edit');

Route::get('task_read/{id}','ticketController@task_read');


// Bagian Export

Route::get('export/{id}','ticketController@export');