<?php

namespace App\Http\Controllers\Documentation;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CreateUserDto;

/**
 * @OA\Components(
 *      @OA\Schema(
 *          schema="user_request",
 *          type="object",
 *          @OA\Property(
 *              property="name",
 *              example="Elizabeth Jhonson",
 *              description="User's full name.",
 *              type="string"
 *          ),
 *          @OA\Property(
 *              property="email",
 *              example="email@email.com",
 *              description="User email must be unique.",
 *              type="string"
 *          ),
 *          @OA\Property(
 *              property="password",
 *              example="@!thi-$",
 *              description="",
 *              type="string"
 *          ),
 *          @OA\Property(
 *              property="cpf",
 *              example="75360676078",
 *              description="Required if the user does not have a cnpj, this will define him as a consumer.",
 *              type="string"
 *          ),
 *          @OA\Property(
 *              property="cnpj",
 *              example="40889832000125",
 *              description="Required if the user does not have a cpf, this will define him as a seller.",
 *              type="string"
 *          )
 *      ),
 *      @OA\Schema(
 *          schema="user_response",
 *          type="object",
 *          @OA\Property(
 *              property="id",
 *              example="1",
 *              description="User reference.",
 *              type="int"
 *          ),
 *          @OA\Property(
 *              property="name",
 *              example="Elizabeth Jhonson",
 *              description="User's full name.",
 *              type="string"
 *          ),
 *          @OA\Property(
 *              property="email",
 *              example="email@email.com",
 *              description="User email must be unique.",
 *              type="string"
 *          ),
 *          @OA\Property(
 *              property="user_entity",
 *              example="seller",
 *              description="User type.",
 *              type="string"
 *          ),
 *          @OA\Property(
 *              property="document",
 *              description="Details about the card brand",
 *              type="object",
 *              @OA\Property(
 *                  property="cpf",
 *                  example="75360676078",
 *                  type="string"
 *              ),
 *              @OA\Property(
 *                  property="cnpj",
 *                  example="40889832000125",
 *                  type="string"
 *              )
 *          ),
 *          @OA\Property(
 *              property="account",
 *              description="Details about the card brand",
 *              type="object",
 *              @OA\Property(
 *                  property="id",
 *                  example="5",
 *                  type="int"
 *              ),
 *              @OA\Property(
 *                  property="account",
 *                  example="121622197-9",
 *                  type="string"
 *              ),
 *              @OA\Property(
 *                  property="number",
 *                  example="152.8",
 *                  type="float"
 *              )
 *          )
 *      )       
 * )
 */

interface UserControllerDocumentation
{
    /**
     * @param CreateUserDto $createUserDto
     * @return  Response
     * @OA\Post(
     *     path="/api/create-users",
     *     summary="Create a new user",
     *     description="This endpoint creates a new user.",
     *     tags={"Create user"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#components/schemas/user_request")
     *      ),
     *     @OA\Response(
     *          response="201",
     *          description="User created successfully.",
     *          @OA\JsonContent(ref="#components/schemas/user_response")
     *      ),
     *      @OA\Response(
     *          response="409",
     *          description="User already exists."
     *      )
     * )
     */
    public function createUser(CreateUserDto $createUserDto): Response;

    /**
     * @param int $userId
     * @return  Response
     * @OA\Get(
     *     path="/api/user/{id}",
     *     summary="Get user by id.",
     *     description="This endpoint get user by your id.",
     *     tags={"Get user"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         example="1",
     *         description="User reference in the application",
     *         @OA\Schema(
     *             type="int"
     *         )
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="",
     *          @OA\JsonContent(ref="#components/schemas/user_response")
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="This user does not exist in the database."
     *      )
     * )
     */
    public function getUser(int $userId): Response;

    /**
     * @param int $userId
     * @param Request $request
     * @return  Response
     * @OA\Put(
     *     path="/api/update/user/{id}",
     *     summary="Update user by id.",
     *     description="This endpoint update data user by your id.",
     *     tags={"Update user"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         example="1",
     *         description="User reference in the application",
     *         @OA\Schema(
     *             type="int"
     *         )
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#components/schemas/user_request")
     *      ),
     *     @OA\Response(
     *          response="204",
     *          description="No content."
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="This user does not exist in the database."
     *      )
     * )
     */
    public function updateUser(int $userId, Request $request): Response;

    /**
     * @param int $userId
     * @return  Response
     * @OA\Delete(
     *     path="/api/delete/user/{id}",
     *     summary="Delete user by id.",
     *     description="This endpoint delete user by your id.",
     *     tags={"Delete user"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         example="1",
     *         description="User reference in the application",
     *         @OA\Schema(
     *             type="int"
     *         )
     *      ),
     *     @OA\Response(
     *          response="204",
     *          description="No content."
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="This user does not exist in the database."
     *      )
     * )
     */
    public function deleteUser(int $userId): Response;
}
