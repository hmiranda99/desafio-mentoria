<?php

namespace App\Exceptions\UsersExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;

class UserAlreadExistsException extends Exception
{
    public const MSG_USER_ALREADY_EXISTS = 'User already exists.';
    
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
            "message" => static::MSG_USER_ALREADY_EXISTS
        ], StatusCodeInterface::STATUS_CONFLICT);
    }
}