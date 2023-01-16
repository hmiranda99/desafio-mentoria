<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Enums\TransactionStatusEnum;
use App\Enums\TransactionsTypesEnum;
use App\Http\Requests\CreateTransactionDto;

class TransactionRepository
{
    protected $transactionTypeRepository;

    public function __construct(TransactionTyperepository $transactionTypeRepository)
    {
        $this->transactionTypeRepository = $transactionTypeRepository;
    }

    public function registerTransaction(TransactionStatusEnum $status, CreateTransactionDto $createTransactionDto)
    {
        $transaction = $this->createTransactionModel($status, $createTransactionDto);
        return $transaction->save();
    }

    private function createTransactionModel(TransactionStatusEnum $status, CreateTransactionDto $createTransactionDto): Transaction
    {
        $transaction = Transaction::query()->newModelInstance();
        $transaction->value = $createTransactionDto->value;
        $transaction->user_payer_id = $createTransactionDto->payer;
        $transaction->user_payee_id = $createTransactionDto->payee;
        $transaction->transaction_type = $this->transactionTypeRepository->getIdTransactionTypeByName(TransactionsTypesEnum::P2P);
        $transaction->status = $status;
        $transaction->transaction_hash = $createTransactionDto->transaction_hash;

        return $transaction;
    }
}
