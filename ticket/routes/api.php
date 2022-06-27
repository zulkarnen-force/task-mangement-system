<?php

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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::get('/users', function (Request $request) {
   $users = User::all();
   return $users;
});


Route::get('/users/{id}', function (Request $request, $id) {
   
   try {
      $user = User::findOrFail($id);
      return response()->json([
         "status" => true,
         "data" => $user
      ], 200);

   } catch (ModelNotFoundException $e) {
      return response()->json(
         ['message' => $e->getMessage()]
         , 404)($e->getMessage(), 404);
   }   catch (Exception $e) {
      
      return $e->getMessage();
      
   } 

 });


 Route::delete('/users/{id}', function(Request $requset, $id) {
   $user = User::destroy($id);
   return $user > 0 ? json_encode(array('success' => true)) : json_encode(array('success' => false)) ;
 });


 Route::get('/tasks', function (Request $request) {
    $tasks = TaskNode::all();
    return $tasks->toJson();
 });


 Route::get('/tasks/{id}', function (Request $request, $id) {
    $task = TaskNode::findOrFail($id);
    return $task->toJson();
 });