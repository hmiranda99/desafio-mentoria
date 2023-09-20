<?php

namespace App\Exceptions\TransactionsExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Http\JsonResponse;

class InsufficientBalanceException extends Exception
{
    public const MSG_INSUFFICIENT_BALANCE = 'Insufficient balance.';

    /**
     * Report the exception.
     * @return bool|null
     */
    public function report(): ?bool
    {
        return false;
    }

    /**
     * Render the exception into an HTTP response.
     * This method returns an error message for users that do not exist.
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            "error" => true,
            "message" => static::MSG_INSUFFICIENT_BALANCE
        ], StatusCodeInterface::STATUS_BAD_REQUEST);
    }
}
