<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ServicesExceptions\ServiceDownException;
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
    public function __construct(
        protected TransactionService $transactionService,
        protected ValidateTransaction $validateTransaction
    ) {
    }

    /**
     * Create a transaction.
     *
     * @param CreateTransactionDto $createTransactionDto
     * @return Response
     * @throws TransactionNotAuthorizedException
     * @throws ServiceDownException
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
