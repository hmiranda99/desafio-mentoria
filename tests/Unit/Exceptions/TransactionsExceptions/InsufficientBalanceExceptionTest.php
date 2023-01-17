<?php

namespace Tests\Unit\Exceptions\TransactionsExceptions;

use App\Exceptions\TransactionsExceptions\InsufficientBalanceException;
use Tests\TestCase;
use Fig\Http\Message\StatusCodeInterface;

class InsufficientBalanceExceptionTest extends TestCase
{
    
    public function testReportException()
    {
        $instance = new InsufficientBalanceException();
        $response = $instance->report();

        $this->assertFalse($response);
    }

    public function testUserAlreadyExistisException()
    {
        $instance = new InsufficientBalanceException();

        $message = response()->json(["error" => true, "message" => $instance::MSG_INSUFFICIENT_BALANCE]);

        $response = $instance->render();

        $this->assertNotEmpty($response);
        $this->assertIsObject($response);
        $this->assertEquals($message->content(), $response->getContent());
        $this->assertInstanceOf(InsufficientBalanceException::class, $instance);   
        $this->assertEquals(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
    }
}
