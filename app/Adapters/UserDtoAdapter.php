<?php

namespace App\Adapters;

use App\Models\UserDto;

class UserDtoAdapter
{
    /**
     * This method converts arrays and objects to the format UserDto.
     * 
     * @param object $dataUser
     * @return UserDto
     */
    public function adapter(?object $dataUser, ?array $data_user, ?int $userId): UserDto
    {
        $attributes = [
            'id' => $userId ?? null,
            'name' => $dataUser->name ?? $data_user['name'],
            'email' => $dataUser->email ?? $data_user['email'],
            'password' => $data_user['password'] ?? $dataUser->password,
            'cnpj' => !empty($dataUser->cnpj) ? $dataUser->cnpj : (!empty($data_user['cnpj']) ? $data_user['cnpj'] : null),
            'cpf' => !empty($dataUser->cpf) ? $dataUser->cpf : (!empty($data_user['cpf']) ? $data_user['cpf'] : null),
            'user_entity' => $dataUser->user_entity ?? $data_user['user_entity']
        ];

        return new UserDto($attributes);
    }
}
