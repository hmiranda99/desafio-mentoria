<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\UserDto;
use Anteris\FakerMap\FakerMap;
use Anteris\DataTransferObjectFactory\Factory;
use Spatie\DataTransferObject\DataTransferObject;

class UserDtoFactory extends Factory
{
    protected static string $dtoClass = UserDto::class;

    /**
     * @return DataTransferObject
     */
    public static function userMakeFactory(): DataTransferObject
    {
        return Factory::new(self::$dtoClass)->make();
    }

    /**
     * @param array $attributes
     * @return DataTransferObject
     */
    public static function userMakeRealFactory(array $attributes = [])
    {
        return Factory::new(self::$dtoClass)
            ->sequence(array_merge([
                'id' => FakerMap::faker()->unique()->randomNumber(2),
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
