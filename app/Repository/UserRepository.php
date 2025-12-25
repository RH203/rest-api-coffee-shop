<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function findUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function findUserByName($name)
    {
        return User::where('name', $name)->first();
    }

    public function createNewUser($name, $email, $password)
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }
}
