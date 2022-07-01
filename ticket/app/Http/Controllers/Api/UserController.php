<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;

use App\Services\CreateUserService;
use App\User as UserModel;
use Exception;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
           $users = UserModel::all();

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request, CreateUserService $createUserService)
    {
        try {
            $user = $createUserService->handle($request);
            return response()->json(['success' => true, 'result' => $user], 201);
        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException) {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        try {
            $user = UserModel::findOrFail($id);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUser $request, $id)
    {

        // PUT
        try {
            $user = UserModel::findOrFail($id);
            $user->update([
                'username' => $request['username'],
                'password' => bcrypt($request['password']),

            ]);

            return response()->json([
                'success' => true,
                'message' => 'user update successfully'
            ]);
        } catch (Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $id;

        try {
            $user = UserModel::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                "result" => $user
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

    
}
