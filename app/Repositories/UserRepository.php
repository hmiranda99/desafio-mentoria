<?php

namespace App\Repositories;

use App\Helpers\AccountHelper;
use App\Models\User;
use App\Models\UserDto;

class UserRepository
{
    public function __construct(AccountHelper $accountHelper)
    {
        $this->accountHelper = $accountHelper;
    }

    /**
     * This method gets the user by email.
     * @param string $email
     * @return ?UserDto
     */
    public function getUserByEmail(string $email): ?UserDto
    {
        $user = User::where('email', 'LIKE', '%' . $email . '%')->first();
        return $user ? new UserDto($user->toArray()) : null;
    }

    /**
     * This method gets the user by email.
     * @param int $userId
     * @return ?UserDto
     */
    public function getUserById(int $userId): ?UserDto
    {
        $user = User::find($userId);
        return $user ? new UserDto($user->toArray()) : null;
    }

    /**
     * This method inserts user data into the database.
     * @param UserDto $userDto
     * @return UserDto
     */
    public function createUser(UserDto $userDto): UserDto
    {
        $accountUserData = $this->accountHelper->accountUserData();
        $user = $this->createUserModel($userDto, null);
        $user->save();
        $user->account()->create($accountUserData);

        return new UserDto($user->toArray());
    }

    /**
     * This method deletes the user data from the database.
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool
    {
        return User::find($userId)->delete();
    }

    /**
     * This method updates the user data in the database.
     * @param UserDto $userDto
     * @param int $userId
     * @return bool
     */
    public function updateUser(UserDto $userDto, int $userId): bool
    {
        $user = $this->createUserModel($userDto, $userId);
        return $user->updateOrFail();
    }

    /**
     * This method prepares the data to be saved in the database.
     * @param UserDto $userDto
     * @param ?int $userId
     * @return User
     */
    private function createUserModel(UserDto $userDto, ?int $userId): User
    {
        $user = $this->hasUserId($userDto, $userId);
        $user->name = $userDto->name;
        $user->email = $userDto->email;
        $user->password = $userDto->password;
        $user->cnpj = $userDto->cnpj;
        $user->cpf = $userDto->cpf;
        $user->user_entity = $userDto->user_entity;

        return $user;
    }

    /**
     * This method checks if the user is already in the database by its id.
     * @param UserDto $userDto
     * @param ?int $userId
     * @return User
     */
    private function hasUserId(UserDto $userDto, ?int $userId): User
    {
        return empty($userDto->id) ? User::query()->newModelInstance() : User::find($userId);
    }
}
