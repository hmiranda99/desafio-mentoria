<?php

namespace Tests\Unit\Exceptions\UsersException;

use Tests\TestCase;
use Fig\Http\Message\StatusCodeInterface;
use App\Exceptions\UsersExceptions\UserAlreadyExistsException;

class UserAlreadyExistisExceptionTest extends TestCase
{
    
    public function testReportException()
    {
        $instance = new UserAlreadyExistsException();
        $response = $instance->report();

        $this->assertFalse($response);
    }

    public function testUserAlreadyExistisException()
    {
        $instance = new UserAlreadyExistsException();

        $message = response()->json(["error" => true, "message" => $instance::MSG_USER_ALREADY_EXISTS]);

        $response = $instance->render();

        $this->assertNotEmpty($response);
        $this->assertIsObject($response);
        $this->assertEquals($message->content(), $response->getContent());
        $this->assertInstanceOf(UserAlreadyExistsException::class, $instance);
        $this->assertEquals(StatusCodeInterface::STATUS_CONFLICT, $response->getStatusCode());
    }
}
