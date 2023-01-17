<?php

namespace App\Exceptions\UsersExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;

class UserNotExistsException extends Exception
{
    public const MSG_USER_NOT_EXISTS = 'This user does not exist in the database.';

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
            "message" => static::MSG_USER_NOT_EXISTS
        ], StatusCodeInterface::STATUS_BAD_REQUEST);
    }
}
