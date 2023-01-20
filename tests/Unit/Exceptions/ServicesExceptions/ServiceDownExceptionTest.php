<?php

namespace Tests\Unit\Exceptions\TransactionsExceptions;

use App\Exceptions\ServicesExceptions\ServiceDownException;
use Tests\TestCase;
use Fig\Http\Message\StatusCodeInterface;

class ServiceDownExceptionTest extends TestCase
{
    
    public function testReportException()
    {
        $instance = new ServiceDownException();
        $response = $instance->report();

        $this->assertFalse($response);
    }

    public function testUserAlreadyExistisException()
    {
        $instance = new ServiceDownException();

        $message = response()->json(["error" => true, "message" => $instance::MSG_SERVICE_DOWN]);

        $response = $instance->render();

        $this->assertNotEmpty($response);
        $this->assertIsObject($response);
        $this->assertEquals($message->content(), $response->getContent());
        $this->assertInstanceOf(ServiceDownException::class, $instance);   
        $this->assertEquals(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}
