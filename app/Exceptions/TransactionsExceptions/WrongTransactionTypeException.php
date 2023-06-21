<?php

namespace App\Exceptions\TransactionsExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;

class WrongTransactionTypeException extends Exception
{
    public const MSG_WRONG_TRANSACTION_TYPE = 'Transaction not authorized.';

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
            "message" => static::MSG_WRONG_TRANSACTION_TYPE
        ], StatusCodeInterface::STATUS_BAD_REQUEST);
    }
}
