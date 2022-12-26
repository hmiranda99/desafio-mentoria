<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\CpfUser;
use App\Rules\CnpjUser;
use App\Models\UserDto;
use App\Exceptions\UsersExceptions\UserNotExistsException;
use App\Repositories\UserRepository;

class UserHelper
{

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * This method defines the type of the user.
     * 
     * @param ?string $documentUser
     * @return string
     */
    public function definesUserEntity(?string $documentUser): string
    {
        return is_null($documentUser) ? 'consumer' : 'seller';
    }

    /**
     * This method checks if the user exists in the database.
     * 
     * @param int $userId
     * @return ?UserDto
     */
    public function hasUser(int $userId): ?UserDto
    {
        if (is_null($userDto = $this->userRepository->getUserById($userId))) {
            throw new UserNotExistsException();
        }

        return $userDto;
    }

    /**
     * This method checks the rules for updating user data.
     * 
     * @param Request $request
     * @param UserDto $userDto
     * @return void
     */
    public function validateRequestUpdate(Request $request, UserDto $userDto): void
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:80',
            'email' => ['required', 'email:rfc,dns', Rule::unique('users')->ignore($userDto->id)],
            'cnpj' => ['max:18', 'required_without:cpf', 'nullable', Rule::unique('users')->ignore($userDto->id), new CnpjUser],
            'cpf' => ['max:14', 'required_without:cnpj', 'nullable', Rule::unique('users')->ignore($userDto->id), new CpfUser]
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors());
        }
    }

    /**
     * This method checks if the user has entered a new password on update.
     * 
     * @param string $newPassword
     * @param int $userId
     * @return string
     */
    public function hasNewPassword(string $newPassword, int $userId): string
    {
        $userDto = $this->userRepository->getUserById($userId);

        if ($newPassword === $userDto->password) {
            return $userDto->password;
        }

        return $this->encryptPassword($newPassword);
    }

    /**
     * This method encrypts the user password.
     * 
     * @param string $password
     * @return string
     */
    public function encryptPassword(string $password): string
    {
        return Hash::make($password);
    }
}
