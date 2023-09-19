<?php

namespace App\Http\Requests;

use App\Rules\CpfUser;
use App\Rules\CnpjUser;
use Spatie\LaravelData\Data;

class CreateUserDto extends Data
{
    public string $name;
    public string $email;
    public string $password;
    public ?string $cnpj;
    public ?string $cpf;
    public ?string $user_entity;

    public static function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:80',
            'email' => 'required|unique:users|email:rfc,dns',
            'password' => 'required',
            'cnpj' => ['unique:users', 'max:18', 'required_without:cpf', 'nullable', new CnpjUser()],
            'cpf' => ['unique:users', 'max:14', 'required_without:cnpj', 'nullable', new CpfUser()],
        ];
    }

    public static function messages(): array
    {
        return [
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
            'cnpj.required_without' => 'Campo CNPJ vazio.',
            //cpf
            'cpf.unique' => 'Este CPF já existe, digite novamente.',
            'cpf.required' => 'O CPF É obrigatório.',
            'cpf.max' => 'Limite de 14 caracteres, digite novamente.',
            'cpf.required_without' => 'Campo CPF vazio.'
        ];
    }
}
