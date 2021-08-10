<?php
namespace App\Http\Controllers\Api;

use App\Enumerators\UserPermission;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
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
     * Método para solicitar a criação de um usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validate = $this-> validate($request, [
                'name' => 'required|string|max:255',
                'cpf' => 'required|cpf|unique:users|max:11',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'is_store' =>  'required|in:0,1',
                'wallet' => 'numeric'
            ],[
                'cpf.unique' => 'Este CPF já está sendo utilizado.',
                'email.unique' => 'Este email já está sendo utilizado.',
            ]);

            $user = $this->userService->save($validate);
            return response()->json(['message' => 'Usuário cadastrado com sucesso!', 'data' => $user]);

        } catch (ValidationException $e) {
            return response()->json(['message' => 'Oops, verifique os campos!', 'errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Oops...O servidor não está respondendo. Tente novamente mais tarde!'], 500);
        }
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
            'is_store' =>  'sometimes|in:0,1',
            'wallet' => 'numeric',
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
