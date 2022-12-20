<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="3.0.0",
 *      title="Desafio backend",
 *      description="Para esse desafio foi desenvolvida uma API escalável que tem como objetivo realizar transferências bancárias entre dois tipos de usuários, comuns e lojistas."
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
