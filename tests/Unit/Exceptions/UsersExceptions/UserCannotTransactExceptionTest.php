<?php

namespace Tests\Unit\Exceptions\UsersException;

use App\Exceptions\UsersExceptions\UserCannotTransactException;
use Tests\TestCase;
use Fig\Http\Message\StatusCodeInterface;

class UserCannotTransactExceptionTest extends TestCase
{
    
    public function testReportException()
    {
        $instance = new UserCannotTransactException();
        $response = $instance->report();

        $this->assertFalse($response);
    }

    public function testUserAlreadyExistisException()
    {
        $instance = new UserCannotTransactException();

        $message = response()->json(["error" => true, "message" => $instance::MSG_USER_CANNOT_TRANSACT]);

        $response = $instance->render();

        $this->assertNotEmpty($response);
        $this->assertIsObject($response);
        $this->assertEquals($message->content(), $response->getContent());
        $this->assertInstanceOf(UserCannotTransactException::class, $instance);   
        $this->assertEquals(StatusCodeInterface::STATUS_FORBIDDEN, $response->getStatusCode());
    }
}
