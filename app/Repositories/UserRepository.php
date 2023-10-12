<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository
{
    public function create_user(string $username, string $password): void
    {
        $hashed_pw = Hash::make($password);

        User::create([
            "username" => $username,
            "password" => $hashed_pw
        ]);
    }

    public function get_user_by_username(string $username): User|null
    {
        return User::where("username", $username)->first();
    }
}
