<?php

namespace App\Exceptions\UsersExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;

class EqualsUsersException extends Exception
{
    public const MSG_EQUALS_USERS_EXISTS = 'Payer and payee cannot be the same.';

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
     * This method returns an error message for users that already exist in database.
     * @param  \Illuminate\Http\Request  
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json([
            "error" => true,
            "message" => static::MSG_EQUALS_USERS_EXISTS
        ], StatusCodeInterface::STATUS_CONFLICT);
    }
}
