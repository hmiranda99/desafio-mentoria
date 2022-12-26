<?php

namespace Tests\Unit\Exceptions\UsersException;

use Tests\TestCase;
use Fig\Http\Message\StatusCodeInterface;
use App\Exceptions\UsersExceptions\UserNotExistsException;

class UserNotExistisExceptionTest extends TestCase
{
    public function testReportException()
    {
        $instance = new UserNotExistsException();
        $response = $instance->report();

        $this->assertFalse($response);
    }

    public function testUserNotExistisException()
    {
        $instance = new UserNotExistsException();

        $message = response()->json(["error" => true, "message" => $instance::MSG_USER_NOT_EXISTS]);

        $response = $instance->render();

        $this->assertNotEmpty($response);
        $this->assertIsObject($response);
        $this->assertEquals($message->content(), $response->getContent());
        $this->assertInstanceOf(UserNotExistsException::class, $instance);   
        $this->assertEquals(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
    }
}
