<?php

namespace Tests\Unit\Jobs;

use App\Exceptions\ServicesExceptions\ServiceDownException;
use App\Jobs\FinalTransactionEmailJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FinalTransactionEmailJobTest extends TestCase
{
    /**
     * @throws ServiceDownException
     */
    public function testHandleSuccess()
    {
        // Configure a fake response for the HTTP request
        Http::fake([
            config('services.send-email-service.base_uri') => Http::response(['message' => 'success.'], 200)
        ]);

        // Disable logging for this test
        Log::shouldReceive('info')->andReturnNull();

        // Create an instance of FinalTransactionEmailJob
        $job = new FinalTransactionEmailJob();

        // Execute the job's handle method
        $job->handle();

        // Assert that the job completed successfully
        $this->assertTrue(true);
    }

    public function testHandleFailure()
    {
        // Configure a fake response for the HTTP request
        Http::fake([
            config('services.send-email-service.base_uri') => Http::response(['message' => 'error.'], 500)
        ]);

        // Disable logging for this test
        Log::shouldReceive('info')->andReturnNull();

        // Create an instance of FinalTransactionEmailJob
        $job = new FinalTransactionEmailJob();

        // Expect a ServiceDownException to be thrown
        $this->expectException(ServiceDownException::class);

        // Execute the job's handle method
        $job->handle();
    }
}
