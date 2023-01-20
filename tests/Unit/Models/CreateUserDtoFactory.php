<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Anteris\FakerMap\FakerMap;
use Anteris\DataTransferObjectFactory\Factory;
use App\Http\Requests\CreateUserDto;

class CreateUserDtoFactory extends Factory
{
    protected static string $dtoClass = CreateUserDto::class;

    /**
     * @return CreateUserDto
     */
    public static function userMakeFactory(): CreateUserDto
    {
        return Factory::new(self::$dtoClass)->make();
    }

    /**
     * @param array $attributes
     * @return CreateUserDto
     */
    public static function makeRealFactory(array $attributes = []): CreateUserDto
    {
        return Factory::new(self::$dtoClass)
            ->sequence(array_merge([
                'name' => FakerMap::faker()->name(),
                'email' => FakerMap::faker()->safeEmail(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'cnpj' => FakerMap::faker()->numerify('##################'),
                'cpf' => FakerMap::faker()->numerify('##############'),
                'user_entity' => FakerMap::faker()->randomElement([
                    User::CONSUMER,
                    User::SELLER
                ])
            ], $attributes))
            ->make();
    }
}
