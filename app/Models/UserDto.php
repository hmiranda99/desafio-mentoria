<?php

namespace App\Models;

use Spatie\DataTransferObject\DataTransferObject;

class UserDto extends DataTransferObject
{
    public ?int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $user_entity;
    public ?string $cnpj;
    public ?string $cpf;
}
