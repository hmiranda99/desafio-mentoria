<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function list()
    {
        $user = User::all();
        if (is_null($user)) {
            return response()->json(["Tabelas inexistentes."], 404);
        }

        return response()->json([$user], 200);
    }

    public function create(UserRequest $request)
    {
        //armazenando os dados nas variáveis para fazer o insert 
        $name = $request['name'];
        $email = $request['email'];
        $password = Hash::make(request('password'));
        $cnpj = $request['cnpj'];
        $cpf = $request['cpf'];

        //verificando o tipo do usuário
        //is_null($cnpj) ? $user_entity = 'consumer' : $user_entity = 'seller';
        $user_entity = is_null($cnpj) ? 'consumer' : 'seller';

        //inserindo o usuário
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'cnpj' => $cnpj,
            'cpf' => $cpf,
            'user_entity' => $user_entity,
        ]);

        //retornando a status code
        return response()->json(["Usuário criado com sucesso!"], 201);
    }
}
