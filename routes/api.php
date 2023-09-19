<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

//health
Route::get('/check', [HealthController::class, 'check']);

//user
Route::get('/user/{id}', [UserController::class, 'getUser']);
Route::post('/user', [UserController::class, 'createUser']);
Route::put('/update/user/{id}', [UserController::class, 'updateUser']);
Route::delete('/delete/user/{id}', [UserController::class, 'deleteUser']);

//transaction
Route::post('/transaction', [TransactionController::class, 'createTransaction']);
