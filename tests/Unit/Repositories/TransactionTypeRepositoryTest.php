<?php

namespace Tests\Unit\Repositories;

use App\Enums\TransactionsTypesEnum;
use App\Models\TransactionType;
use App\Repositories\TransactionTypeRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TransactionTypeRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testShoulGetIdTransactionTypeByName()
    {
        $transactionType = TransactionType::factory()->createOne(['description' => TransactionsTypesEnum::P2P]);

        $instance = new TransactionTypeRepository();
        $response = $instance->getIdTransactionTypeByName(TransactionsTypesEnum::P2P->value);

        $this->assertEquals($transactionType->id, $response);
    }
}