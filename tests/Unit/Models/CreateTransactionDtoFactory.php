<?php

namespace Tests\Unit\Models;

use Anteris\FakerMap\FakerMap;
use Anteris\DataTransferObjectFactory\Factory;
use App\Enums\TransactionsTypesEnum;
use App\Http\Requests\CreateTransactionDto;

class CreateTransactionDtoFactory extends Factory
{
    protected static string $dtoClass = CreateTransactionDto::class;

    /**
     * @return CreateTransactionDto
     */
    public static function makeFactory(): CreateTransactionDto
    {
        return Factory::new(self::$dtoClass)->make();
    }

    /**
     * @param array $attributes
     * @return CreateTransactionDto
     */
    public static function makeRealFactory(array $attributes = []): CreateTransactionDto
    {
        return Factory::new(self::$dtoClass)
            ->sequence(array_merge([
                'value' => FakerMap::faker()->randomFloat(2, 1, 2),
                'payer' => FakerMap::faker()->unique()->randomNumber(2),
                'payee' => FakerMap::faker()->unique()->randomNumber(2),
                'type' => FakerMap::faker()->randomElement([
                    TransactionsTypesEnum::P2P->value
                ]),
                'transactionHash' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
            ], $attributes))
            ->make();
    }
}
