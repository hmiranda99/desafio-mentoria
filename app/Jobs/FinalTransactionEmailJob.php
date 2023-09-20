<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Exceptions\ServicesExceptions\ServiceDownException;

class FinalTransactionEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    protected function buildBaseUrl(): string
    {
        return config('services.send-email-service.base_uri');
    }

    /**
     * Execute the job.
     * @return void
     * @throws ServiceDownException
     */
    public function handle(): void
    {
        $response = Http::get($this->buildBaseUrl());
        $response = $response->json();

        if ($response['message'] != 'success.') {
            throw new ServiceDownException();
        }

        Log::info("Email successfully sent!");
    }
}
