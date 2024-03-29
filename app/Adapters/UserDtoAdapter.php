<?php

namespace App\Adapters;

use App\Models\UserDto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UserDtoAdapter
{
    /**
     * This method converts arrays and objects to the format UserDto.
     * @param object|null $dataUserObject
     * @param array|null $dataUserArray
     * @param int|null $userId
     * @return UserDto
     * @throws UnknownProperties
     */
    public function adapter(?object $dataUserObject, ?array $dataUserArray, ?int $userId): UserDto
    {
        $attributes = [
            'id' => $userId ?? null,
            'name' => $dataUserObject->name ?? $dataUserArray['name'],
            'email' => $dataUserObject->email ?? $dataUserArray['email'],
            'password' => $dataUserArray['password'] ?? $dataUserObject->password,
            'cnpj' => !empty($dataUserObject->cnpj) ? $dataUserObject->cnpj :
                        (!empty($dataUserArray['cnpj']) ? $dataUserArray['cnpj'] : null),
            'cpf' => !empty($dataUserObject->cpf) ? $dataUserObject->cpf :
                        (!empty($dataUserArray['cpf']) ? $dataUserArray['cpf'] : null),
            'user_entity' => $dataUserObject->user_entity ?? $dataUserArray['user_entity']
        ];

        return new UserDto($attributes);
    }
}
