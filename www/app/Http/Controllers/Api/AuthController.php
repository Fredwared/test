<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Models\User;

/**
 * @group Authentication
 */
class AuthController extends Controller
{
    /**
     * Login
     *
     * @bodyParam string email Email of the user. Default: admin@example.com
     * @bodyParam string password Password. Default: password
     *
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $loginRequest, LoginAction $loginAction)
    {
        /** @var User $user */
        $user = $loginAction->execute($loginRequest->validated());

        if (! $user->exists) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return (new UserResource($user))->additional([
            'access_token' => $user->createToken('access_token')->plainTextToken,
        ]);
    }

    /**
     * Register user
     *
     * @return UserResource
     *
     * @bodyParam name string required Name of the user
     * @bodyParam email string required Email address of the user
     * @bodyParam password string required Password of the user
     * @bodyParam password_confirmed string required Password of the user
     */
    public function register(RegisterRequest $registerRequest, RegisterAction $action)
    {
        /** @var User $user */
        $user = $action->execute($registerRequest->validated());

        return (new UserResource($user))->additional([
            'access_token' => $user->createToken('access_token')->plainTextToken,
        ]);
    }
}
