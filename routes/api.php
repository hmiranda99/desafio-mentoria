<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\UserController;

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

Route::get('/check', [HealthController::class, 'check']);
Route::post('/create-users', [UserController::class, 'createUser']);
Route::get('/list/user/{id}', [UserController::class, 'getUser']);
Route::delete('/delete/user/{id}', [UserController::class, 'deleteUser']);
Route::put('/update/user/{id}', [UserController::class, 'updateUser']);