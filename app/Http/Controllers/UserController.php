<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Rules\CnpjUser;
use App\Rules\CpfUser;

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

    public function create(Request $request)
    {
        //mensagens retornando o erro
        $mensagens = [
            //'required' => 'O :attribute é obrigatório.',

            //nome
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'É permitido somente letras no nome.',
            'name.min' => 'É necessário no mínimo 2 caracteres no nome.',
            'name.max' => 'Quantidade máxima permitida é de 80 caracteres, digite novamente.',
            //email
            'email.required' => 'O email é obrigatório.',
            'email.unique' => 'Este email já existe, digite novamente.',
            'email.email' => 'Email inválido, digite novamente.',
            //senha
            'password.required' => 'A senha é obrigatória.',
            //cnpj
            'cnpj.unique' => 'Este CNPJ já existe, digite novamente.',
            'cnpj.max' => 'Limite de 18 caracteres, digite novamente.',
            'cnpj.required' => 'O CNPJ É obrigatório.',
            //cpf
            'cpf.unique' => 'Este CPF já existe, digite novamente.',
            'cpf.required' => 'O CPF É obrigatório.',
        ];
        //levar p o request

        //validação dos campos
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|min:2|max:80',
                'email' => 'required|unique:users|email:rfc,dns',
                'password' => 'required',
                'cnpj' => ['unique:users', 'max:18', 'nullable', new CnpjUser],
                'cpf' => ['unique:users', 'nullable', new CpfUser],
            ],
            $mensagens
        );

        //validação dentro de roule

        //se houver erro, retornar a mensagem
        if ($validator->fails()) {
            return response()
                ->json($validator->errors()
            );//status code
        }

        //armazenando os dados nas variáveis para fazer o insert 
        $name = $request['name'];
        $email = $request['email'];
        $password = Hash::make(request('password'));
        $cnpj = $request['cnpj'];
        $cpf = $request['cpf'];

        //verificando o tipo do usuário
        //is_null($cnpj) ? $user_entity = 'consumer' : $user_entity = 'seller';
        $user_entity = is_null($cnpj) ? 'consumer' : 'seller';

        //adicionando a data de criação
        date_default_timezone_set('America/Sao_Paulo');
        $created = date('m-d-Y h:i:s', time());

        //inserindo o usuário
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'cnpj' => $cnpj,
            'cpf' => $cpf,
            'user_entity' => $user_entity,
            'created_at' => $created,
        ]);

        //criar seed transaction type

        //retornando a status code
        return response()->json(["Usuário criado com sucesso!"], 201);
    }
}
