<?php

namespace App\Exceptions\UsersExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;

class UserCannotTransactException extends Exception
{
    public const MSG_USER_CANNOT_TRANSACT = 'Seller entity users cannot transact, only receive.';

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
            "message" => static::MSG_USER_CANNOT_TRANSACT
        ], StatusCodeInterface::STATUS_FORBIDDEN);
    }
}
