<?php

namespace App\Exceptions\TransactionsExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;

class InsufficientBalanceException extends Exception
{
    public const MSG_INSUFFICIENT_BALANCE = 'Insufficient balance.';

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        return false;
    }
 
    /**
     * Render the exception into an HTTP response.
     * This method returns an error message for users that do not exist.
     *
     * @param  \Illuminate\Http\Request  
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json(["error" => true, "message" => static::MSG_INSUFFICIENT_BALANCE], StatusCodeInterface::STATUS_BAD_REQUEST);
    }
}
