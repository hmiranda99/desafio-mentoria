<?php

namespace App\Exceptions\TransactionsExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;

class TransactionNotAuthorizedException extends Exception
{
    public const MSG_TRANSACTION_NOT_AUTHORIZED = 'Transaction not authorized.';

    /**
     * Report the exception.
     * @return bool|null
     */
    public function report()
    {
        return false;
    }

    /**
     * Render the exception into an HTTP response.
     * This method returns an error message for users that do not exist.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json([
            "error" => true,
            "message" => static::MSG_TRANSACTION_NOT_AUTHORIZED
        ], StatusCodeInterface::STATUS_BAD_REQUEST);
    }
}
