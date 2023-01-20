<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\TransactionType;
use App\Enums\TransactionStatusEnum;
use App\Enums\TransactionsTypesEnum;
use App\Repositories\TransactionRepository;
use App\Repositories\TransactionTypeRepository;
use Tests\Unit\Models\CreateTransactionDtoFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TransactionRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    private $transactionTypeRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->transactionTypeRepository = $this->createMock(TransactionTypeRepository::class);
    }

    public function testShoulCreateTransaction()
    {
        $transactionType = TransactionType::factory()->createOne(['description' => TransactionsTypesEnum::P2P]);
        $createTransaction = CreateTransactionDtoFactory::makeRealFactory();

        $this->transactionTypeRepository
            ->expects($this->once())
            ->method('getIdTransactionTypeByName')
            ->with($createTransaction->type)
            ->willReturn($transactionType->id);

        $instance = new TransactionRepository($this->transactionTypeRepository);

        $reponse = $instance->registerTransaction(TransactionStatusEnum::AUT, $createTransaction);

        $this->assertTrue($reponse);
    }
}