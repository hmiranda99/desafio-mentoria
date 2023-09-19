<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class HealthController extends Controller
{
    /**
     * Check application health.
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        return response()->json(
            ['status' => 200]
        );
    }
}
