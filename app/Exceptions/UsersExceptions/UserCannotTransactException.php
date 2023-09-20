<?php

namespace App\Exceptions\UsersExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Http\JsonResponse;

class UserCannotTransactException extends Exception
{
    public const MSG_USER_CANNOT_TRANSACT = 'Seller entity users cannot transact, only receive.';

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
            "message" => static::MSG_USER_CANNOT_TRANSACT
        ], StatusCodeInterface::STATUS_FORBIDDEN);
    }
}
