<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Enums\TransactionStatusEnum;
use App\Http\Requests\CreateTransactionDto;

class TransactionRepository
{
    public function __construct(protected TransactionTypeRepository $transactionTypeRepository)
    {
    }

    /**
     * This method is responsible for preparing the data for insertion into the database.
     * @param TransactionStatusEnum $status
     * @param CreateTransactionDto $createTransactionDto
     * @return bool
     */
    public function registerTransaction(TransactionStatusEnum $status, CreateTransactionDto $createTransactionDto): bool
    {
        $transactionTypeId = $this->transactionTypeRepository->getIdTransactionTypeByName(
            $createTransactionDto->type
        );

        $transaction = $this->createTransactionModel($status, $createTransactionDto, $transactionTypeId);

        return $transaction->save();
    }

    /**
     * This method is responsible for preparing the data for insertion into the database.
     * @param TransactionStatusEnum $status
     * @param CreateTransactionDto $createTransactionDto
     * @param int $transactionTypeId
     * @return Transaction
     */
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
