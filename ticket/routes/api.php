<?php

use App\Http\Controllers\Api\AuthController;
use App\TaskNode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** 
* http://localhost:8000/api/auth/@method
* 
*/

Route::group(['prefix' => 'auth'], function () {
   Route::get('token', 'Api\AuthController@getToken');
   Route::get('refresh', 'Api\AuthController@refresh')->name('api.auth.refresh');
   Route::get('info', 'Api\AuthController@info')->name('api.auth.info');
   Route::post('logout', 'Api\AuthController@logout')->name('api.auth.logout');
   
});


Route::resource('users', 'Api\UserController', ['names' => [ 
   'update' => 'api.users.update',
   'store' => 'api.users.store',
   'index' => 'api.users.index',
   'destroy' => 'api.users.destory',
   'show' => 'api.users.show',
], 'except' => ['edit', 'create']]);


Route::resource('tasks', 'Api\TaskController', ['names' => [ 
   'update' => 'api.tasks.update',
   'store' => 'api.tasks.store',
   'index' => 'api.tasks.index',
   'destroy' => 'api.tasks.destory',
   'show' => 'api.tasks.show',
], 'except' => ['edit', 'create']]);


Route::resource('tickets', 'Api\TicketController', ['names' => [ 
   'update' => 'api.tickets.update',
   'store' => 'api.tickets.store',
   'index' => 'api.tickets.index',
   'destroy' => 'api.tickets.destory',
   'show' => 'api.tickets.show',
], 'except' => ['edit', 'create']]);





