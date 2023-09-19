<?php

namespace App\Exceptions\UsersExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Http\JsonResponse;

class EqualsUsersException extends Exception
{
    public const MSG_EQUALS_USERS_EXISTS = 'Payer and payee cannot be the same.';

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
     * This method returns an error message for users that already exist in database.
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            "error" => true,
            "message" => static::MSG_EQUALS_USERS_EXISTS
        ], StatusCodeInterface::STATUS_CONFLICT);
    }
}
