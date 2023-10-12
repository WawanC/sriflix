<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userRepository->get_user_by_username($validated['username']);
        if ($user) {
            throw new HttpResponseException(response()->json([
                "message" => "Username already exists"
            ], 409));
        }

        $this->userRepository->create_user($validated['username'], $validated['password']);

        return response()->json([
            "message" => "Success"
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userRepository->get_user_by_username($validated['username']);
        if (!$user || !Hash::check($validated['password'], $user['password'])) {
            throw new HttpResponseException(response()->json([
                "message" => "Wrong credentials"
            ], 401));
        }

        $user->tokens()->delete();

        $accessToken = $user->createToken("access_token", ["*"], Carbon::now()->addMinutes(15))->plainTextToken;

        return response()->json([
            "message" => "Success",
            "access_token" => $accessToken
        ]);
    }

    public function get_me(Request $request)
    {
        $userData = [
            "username" => $request->user()['username']
        ];

        return response()->json([
            "message" => "Success",
            "user" => $userData
        ]);
    }
}
