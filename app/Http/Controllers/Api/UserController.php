<?php
namespace App\Http\Controllers\Api;

use App\Enumerators\UserPermission;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LaravelLegends\PtBrValidator\Rules\FormatoCpf;

class UserController extends Controller
{
    private $userService;

    public function  __construct (UserService $service) {
        
        $this-> userService = $service;
    }

    public function index()
    {
        $user = $this-> userService->getAll();
        return $user;
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this-> validate($request, [

        'name' => 'required|string|max:255',
        'cpf' => 'required|cpf|unique:users|max:11',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'is_store' =>  'required'

        ]);

        $user = $this->userService->save($validate);
         return response($user, Response::HTTP_CREATED);
    }

 
    public function show($id)
    {
        $user = $this->userService->findOrFail($id);
        return response($user);
    }

 
    public function update(Request $request, $id)
    {
        $validate = $this->validate($request , [
            'name' => 'sometimes|string|max:255',
            'cpf' => 'sometimes|cpf|unique:users|max:11',
            'email' => 'sometimes|email|unique:users',
            'password' => 'sometimes|min:8',
            'is_store' =>  'sometimes'
        ]);

        $user = $this->userService->updateById($id, $validate);
        return response($user);
    }


    public function destroy($id)
    {
        $this->userService->deleteById($id);
        return response([], Response::HTTP_NO_CONTENT);
    }
}
