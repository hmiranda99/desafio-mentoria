<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * @method create() create the users by 
     * @param UserRequest $request 
     */
    public function create(UserRequest $request)
    {
        $name = $request['name'];
        $email = $request['email'];
        $password = Hash::make(request('password'));
        $cnpj = $request['cnpj'];
        $cpf = $request['cpf'];

        //is_null($cnpj) ? $user_entity = 'consumer' : $user_entity = 'seller';
        $user_entity = is_null($cnpj) ? 'consumer' : 'seller';

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'cnpj' => $cnpj,
            'cpf' => $cpf,
            'user_entity' => $user_entity,
        ]);

        return response()->json(["Usuário criado com sucesso!"], 201);
    }

    /**
    * @OA\Get(
    *     path="/users",
    *     description="List users",
    *     @OA\Response(response="default", description="Welcome page")
    * )
    */
    public function list()
    {

        $user = User::select('id', 'name', 'email', 'password', 'cnpj', 'cpf', 'user_entity')->get();

        if (is_null($user)) {
            return response()->json(["Tabelas inexistentes."], 404);
        }

        return response()->json([$user], 200);
    }

    /**
     * @method get() get user by 
     * @param int $id
     */
    public function get(int $id)
    {
        $id = User::find([$id], ['id', 'name', 'email', 'password', 'cnpj', 'cpf', 'user_entity']);

        if (is_null($id)) {
            return response()->json(["Esse usuário não existe."], 404);
        }

        return response()->json([$id], 200);
    }

    /**
     * @method delete() delete user by 
     * @param int $id
     */
    public function delete($id)
    {
        $id = User::find($id);

        if (is_null($id)) {
            return response()->json(["O usuário que você está tentando deletar não existe."], 404);
        }

        $id->delete();
        return response()->json(["O usuário foi deletado com sucesso!"], 200);
    }

    public function update(int $userId, Request $request)
    {
        try {
            $userId = User::find($userId);

            if (is_null($userId)) {
                return response()->json(["Esse usuário não existe."], 404);
            }
            
            $password = $request->input('password');

            if(!is_null($password)){
                $request['password'] = Hash::make($password);
            }

            $userId->update(
                $request->all()
            );

            return response()->json([$userId], 200);
        } catch (\Exception $e) {
            return response()->json([$e]);
        }
    }
}
