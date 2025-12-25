<?php

namespace App\Service;

use App\Enum\RoleEnum;
use App\Exceptions\LoginException;
use App\Exceptions\RegisterException;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($request)
    {
        $user = ! empty($request['email']) ?
            $this->userRepository->findUserByEmail($request['email']) :
            $this->userRepository->findUserByName($request['name']);

        if (! $user || ! Hash::check($request['password'], $user->password)) {
            throw new LoginException('Email atau password salah!');
        }

        return $user->createToken('api-token')->plainTextToken;
    }

    public function register($request)
    {
        $newUser = $this->userRepository->createNewUser($request['name'], $request['email'], Hash::make($request['password']));

        if (! $newUser) {
            throw new RegisterException('Error ketika membuat user baru!');
        }

        if (! empty($request['role']) && $request['role'] == RoleEnum::ADMIN->value && Auth::user()->hasRole(RoleEnum::ADMIN->value)) {
            $newUser->assignRole(RoleEnum::ADMIN->value);
        }

        $newUser->assignRole($request['role']);

        return 'User berhasil dibuat!';
    }
}
