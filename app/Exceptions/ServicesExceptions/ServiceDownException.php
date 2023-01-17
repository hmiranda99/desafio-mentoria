<?php

namespace App\Exceptions\ServicesExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;

class ServiceDownException extends Exception
{
    public const MSG_SERVICE_DOWN = 'The service is temporarily down.';

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
            "message" => static::MSG_SERVICE_DOWN
        ], StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
    }
}
