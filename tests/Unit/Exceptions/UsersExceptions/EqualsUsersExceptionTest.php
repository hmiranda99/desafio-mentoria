<?php

namespace Tests\Unit\Exceptions\UsersException;

use App\Exceptions\UsersExceptions\EqualsUsersException;
use Tests\TestCase;
use Fig\Http\Message\StatusCodeInterface;

class EqualsUsersExceptionTest extends TestCase
{
    
    public function testReportException()
    {
        $instance = new EqualsUsersException();
        $response = $instance->report();

        $this->assertFalse($response);
    }

    public function testUserAlreadyExistisException()
    {
        $instance = new EqualsUsersException();

        $message = response()->json(["error" => true, "message" => $instance::MSG_EQUALS_USERS_EXISTS]);

        $response = $instance->render();

        $this->assertNotEmpty($response);
        $this->assertIsObject($response);
        $this->assertEquals($message->content(), $response->getContent());
        $this->assertInstanceOf(EqualsUsersException::class, $instance);   
        $this->assertEquals(StatusCodeInterface::STATUS_CONFLICT, $response->getStatusCode());
    }
}
