<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Enums\TransactionStatusEnum;
use App\Enums\TransactionsTypesEnum;
use App\Http\Requests\CreateTransactionDto;

class TransactionRepository
{
    protected $transactionTypeRepository;

    public function __construct(TransactionTypeRepository $transactionTypeRepository)
    {
        $this->transactionTypeRepository = $transactionTypeRepository;
    }

    public function registerTransaction(TransactionStatusEnum $status, CreateTransactionDto $createTransactionDto)
    {
        $transactionTypeId = $this->transactionTypeRepository->getIdTransactionTypeByName(
            $createTransactionDto->type
        );

        $transaction = $this->createTransactionModel($status, $createTransactionDto, $transactionTypeId);

        return $transaction->save();
    }

    private function createTransactionModel(
        TransactionStatusEnum $status,
        CreateTransactionDto $createTransactionDto,
        int $transactionTypeId
    ): Transaction {
        $transaction = Transaction::query()->newModelInstance();
        $transaction->value = $createTransactionDto->value;
        $transaction->user_payer_id = $createTransactionDto->payer;
        $transaction->user_payee_id = $createTransactionDto->payee;
        $transaction->transaction_type = $transactionTypeId;
        $transaction->status = $status;

        return $transaction;
    }
}
