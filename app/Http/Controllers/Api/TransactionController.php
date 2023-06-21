<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Transactions\TransactionService;
use App\Jobs\FinalTransactionEmailJob;
use Fig\Http\Message\StatusCodeInterface;
use App\Http\Requests\CreateTransactionDto;
use App\Http\Controllers\Api\ValidateTransaction;
use App\Exceptions\TransactionsExceptions\TransactionNotAuthorizedException;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    protected $transactionService;
    protected $validateTransaction;

    public function __construct(
        TransactionService $transactionService,
        ValidateTransaction $validateTransaction
    ) {
        $this->transactionService = $transactionService;
        $this->validateTransaction = $validateTransaction;
    }

    /**
     * Create a transaction.
     * 
     * @param CreateTransactionDto $createTransactionDto
     * @return Response
     */
    public function createTransaction(CreateTransactionDto $createTransactionDto): Response
    {
        $this->validateTransaction->handle($createTransactionDto);

        if (!$this->transactionService->authorizeServiceProvider()) {
            $this->transactionService->cancelTransaction($createTransactionDto);
            throw new TransactionNotAuthorizedException();
        }

        $this->transactionService->authorizeTransaction($createTransactionDto);

        FinalTransactionEmailJob::dispatch();

        return response(null, StatusCodeInterface::STATUS_CREATED);
    }
}
