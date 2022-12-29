<?php

namespace Tests\Unit\Models;

use Anteris\FakerMap\FakerMap;
use Anteris\DataTransferObjectFactory\Factory;
use App\Models\AccountDto;

class AccountDtoFactory extends Factory
{
    protected static string $dtoClass = AccountDto::class;

    /**
     * @param array $attributes
     * @return AccountDto
     */
    public static function accountMakeRealFactory(array $attributes = []): AccountDto
    {
        return Factory::new(self::$dtoClass)
            ->sequence(array_merge([
                'id' => FakerMap::faker()->unique()->randomNumber(2),
                'number' => FakerMap::faker()->numerify('#########'),
                'balance' => FakerMap::faker()->randomFloat(2, 100, 200)
            ], $attributes))
            ->make();
    }
}
