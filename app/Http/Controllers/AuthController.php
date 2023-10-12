<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Exceptions\HttpResponseException;

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
}
