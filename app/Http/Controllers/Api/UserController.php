<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Adapters\UserDtoAdapter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserDto;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Repositories\AccountRepository;
use Fig\Http\Message\StatusCodeInterface;
use App\Exceptions\UsersExceptions\UserAlreadExistsException;

class UserController extends Controller
{
    protected $userRepository;
    protected $userDtoAdapter;
    protected $userHelper;
    protected $accountRepository;

    public function __construct(
        UserRepository $userRepository,
        UserDtoAdapter $userDtoAdapter,
        UserHelper $userHelper,
        AccountRepository $accountRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userDtoAdapter = $userDtoAdapter;
        $this->userHelper = $userHelper;
        $this->accountRepository = $accountRepository;
    }


    /**
     * This method creates a new user and an account for him.
     * @param  CreateUserDto $createUserDto
     * @return Response
     */
    public function createUser(CreateUserDto $createUserDto): Response
    {
        if ($this->userRepository->getUserByEmail($createUserDto->email)) {
            throw new UserAlreadExistsException();
        }

        $createUserDto->user_entity = $this->userHelper->definesUserEntity($createUserDto->cnpj);
        $createUserDto->password = $this->userHelper->encryptPassword($createUserDto->password);
        $userDto = $this->userDtoAdapter->adapter($createUserDto, null, null);
        $userDto = $this->userRepository->createUser($userDto);

        $account = $this->accountRepository->getAccountByUserId($userDto->id);
        $userDto->account = $account;

        return response(UserResource::make($userDto), StatusCodeInterface::STATUS_CREATED);
    }


    /**
     * This method gets a user by id.
     * @param  int $userId
     * @return Response
     */
    public function getUser(int $userId): Response
    {
        $userDto = $this->userHelper->hasUser($userId);
        $account = $this->accountRepository->getAccountByUserId($userId);
        $userDto->account = $account;

        return response(UserResource::make($userDto), StatusCodeInterface::STATUS_OK);
    }

    /**
     * This method deletes a user by id.
     * @param  int $userId
     * @return Response
     */
    public function deleteUser(int $userId): Response
    {
        $this->userHelper->hasUser($userId);
        $this->userRepository->deleteUser($userId);
        $this->accountRepository->deleteAccountByUserId($userId);
        return response(null, StatusCodeInterface::STATUS_NO_CONTENT);
    }

    /**
     * This method updates a user's data by id.
     * @param  int $userId
     * @param Request
     * @return Response
     */
    public function updateUser(int $userId, Request $request): Response
    {
        $userDto = $this->userHelper->hasUser($userId);
        $this->userHelper->validateRequestUpdate($request, $userDto);

        $request['user_entity'] = $this->userHelper->definesUserEntity($request['cnpj']);
        $request['password'] = $this->userHelper->hasNewPassword($request['password'], $userId);

        $userRequestDto = $this->userDtoAdapter->adapter(null, $request->toArray(), $userId);
        $this->userRepository->updateUser($userRequestDto, $userId);

        return response(null, StatusCodeInterface::STATUS_NO_CONTENT);
    }
}
