<?php

namespace App\Exceptions\UsersExceptions;

use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Http\JsonResponse;

class UserAlreadyExistsException extends Exception
{
    public const MSG_USER_ALREADY_EXISTS = 'User already exists.';

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
            "message" => static::MSG_USER_ALREADY_EXISTS
        ], StatusCodeInterface::STATUS_CONFLICT);
    }
}
