<?php

namespace App\Services;

use App\Enums\TransactionStatusEnum;
use App\Http\Requests\CreateTransactionDto;
use App\Repositories\TransactionRepository;
use App\Services\ServiceAuthorizer\AuthorizerService;
use App\Exceptions\TransactionsExceptions\InsufficientBalanceException;
use App\Helpers\TransactionHelper;

class TransactionService
{
    protected $serviceAuthorizer;
    protected $transactionRepository;
    protected $transactionHelper;

    public function __construct(
        AuthorizerService $serviceAuthorizer,
        TransactionRepository $transactionRepository,
        TransactionHelper $transactionHelper
    ) {
        $this->serviceAuthorizer = $serviceAuthorizer;
        $this->transactionRepository = $transactionRepository;
        $this->transactionHelper = $transactionHelper;
    }

    public function authorizeService()
    {
        return $this->serviceAuthorizer->checkAuthorizer();
    }

    public function captureTransaction(CreateTransactionDto $createTransactionDto)
    {
        if (!$this->transactionHelper->haveBalanceToTransact(
            $createTransactionDto->value,
            $createTransactionDto->payer
        )) {
            $this->cancelTransaction($createTransactionDto);
            throw new InsufficientBalanceException();
        }

        return $this->transactionRepository->registerTransaction(TransactionStatusEnum::CAP, $createTransactionDto);
    }

    public function cancelTransaction(CreateTransactionDto $createTransactionDto)
    {
        return $this->transactionRepository->registerTransaction(TransactionStatusEnum::NOT, $createTransactionDto);
    }

    public function errorTransaction(CreateTransactionDto $createTransactionDto)
    {
        $this->transactionRepository->registerTransaction(TransactionStatusEnum::ERR, $createTransactionDto);
        return $this->transactionHelper->prepareAddBalance($createTransactionDto->payer, $createTransactionDto->value);
    }

    public function authorizeTransaction(CreateTransactionDto $createTransactionDto)
    {
        $this->transactionRepository->registerTransaction(TransactionStatusEnum::AUT, $createTransactionDto);
        return $this->transactionHelper->prepareAddBalance($createTransactionDto->payee, $createTransactionDto->value);
    }
}
