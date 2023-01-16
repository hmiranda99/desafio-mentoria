<?php

namespace App\Services\ServiceAuthorizer;

use Illuminate\Support\Facades\Http;
use Fig\Http\Message\StatusCodeInterface;

class AuthorizerService
{
    private $url;

    private const ENV_URL_SERVICE_AUTHORIZER = 'URL_SERVICE_AUTHORIZER';

    public function __construct()
    {
        $this->url = (string) env(self::ENV_URL_SERVICE_AUTHORIZER);
    }

    public function checkAuthorizer()
    {
        $response = Http::withOptions(['verify' => false])->get($this->url);
        return $this->checkStatusCode($response->status());
    }

    private function checkStatusCode(int $statusCode)
    {
        return $statusCode == StatusCodeInterface::STATUS_OK ?? null;
    }
}
