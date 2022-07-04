<?php

namespace App\Services;

use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class UserService
{
    public static function create($request) : JsonResponse
    {
        
        $username = $request['username'];
        $password = $request['password'];

        try {
            $user = User::create([
                'username' => $username,
                'password' => $password,
                'type' => 'role'
            ]);
            return response()->json(['success' => true, 'result' => $user], 201);

        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException || $e instanceof QueryException ) {
                return response()->json(
                    ['success' => false,
                        'message' => $e->getMessage()], 400);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'class' => get_class($e)
                    ], 400);
            }
        }

    }


    public static function getUsers() : JsonResponse
    {
        $users = User::all();

           if (count($users) === 0) {
            return response()->json([
                'success' => false,
                'length' => count($users)
            ], 404);
           }

           return response()->json([
            'success' => true,
            'result' => $users,
            'length' => count($users)
        ], 200);
    }


    public static function getUserById($id) : JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'success' => true,
                'result' => $user
            ], 200);

        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(
                    ['success' => false,
                        'message' => 'User with '.$id.' not found'], 404);
            } else {
                return response()->json(
                    ['success' => false,
                        'message' => $e->getMessage()], 404);
            }
        }  
    }


    public static function delete($id) : JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                "result" => $user
            ], 200);

        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException || $e instanceof QueryException) {
                return response()->json(
                    ['success' => false,
                        'message' => 'User with '.$id.' not found'], 404);
            } else {
                return response()->json(
                    ['success' => false,
                        'message' => $e->getMessage()], 404);
            }
        }  
    }


    public static function update($request, $id) : JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->update([
                'username' => $request['username'],
                'password' => bcrypt($request['password']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'user update successfully'
            ]);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
}

?>