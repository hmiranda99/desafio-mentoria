<?php

namespace App\Services\AuthorizingService;

use Illuminate\Support\Facades\Http;

class AuthorizingService
{
    private string $url;

    public function __construct()
    {
        $this->url = config('services.authorizing-service.base_uri');
    }

    /**
     * This method is responsible for connecting to the external service.
     * @return int
     */
    public function getAuthorizer(): int
    {
        $response = Http::withOptions(['verify' => false])->get($this->url);
        return $response->status();
    }
}
