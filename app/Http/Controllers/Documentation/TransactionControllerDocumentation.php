<?php

namespace App\Http\Controllers\Documentation;

use Illuminate\Http\Response;
use App\Http\Requests\CreateTransactionDto;

/**
 * @OA\Schema(
 *  schema="transaction_request",
 *  type="object",
 *      @OA\Property(
 *          property="value",
 *          example="100",
 *          description="Value of transaction.",
 *          type="int"
 *      ),
 *      @OA\Property(
 *          property="payer",
 *          example="1",
 *          description="User ID",
 *          type="int"
 *      ),
 *      @OA\Property(
 *          property="payee",
 *          example="2",
 *          description="User ID",
 *          type="int"
 *      )
 * )
 */

interface TransactionControllerDocumentation
{
    /**
     * @param CreateTransactionDto $createTransactionDto
     * @return  Response
     * 
     * @OA\Post(
     *     path="/api/transaction",
     *     summary="Create a transaction",
     *     description="This endpoint creates a transaction.",
     *     tags={"Create Transaction"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#components/schemas/transaction_request")
     *      ),
     *     @OA\Response(
     *          response="201", 
     *          description="Transaction created successfully."
     *      ),
     *      @OA\Response(
     *          response="400", 
     *          description="Insufficient balance."
     *      ),
     *      @OA\Response(
     *          response="403", 
     *          description="Seller entity users cannot transact, only receive."
     *      ),
     *      @OA\Response(
     *          response="409", 
     *          description="Payer and payee cannot be the same."
     *      ),
     *      @OA\Response(
     *          response="500", 
     *          description="The service is temporarily down."
     *      )
     * )
     */
    public function createUser(CreateTransactionDto $createTransactionDto): Response;
}
