<?php

namespace App\Http\Controllers\Api;

use App\Actions\User\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Get own user details
     *
     * @return UserResource
     */
    public function me(): UserResource
    {
        return new UserResource(Auth::user());
    }

    public function index(): AnonymousResourceCollection
    {
        $users = User::query()->paginate();

        return UserResource::collection($users);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the user
     *
     * @param User $user
     * @param UpdateUserRequest $updateUserRequest
     * @param UpdateUserAction $updateUserAction
     * @bodyParam string name Name of user
     * @bodyParam string email email of user
     * @return User|null
     */
    public function update(User $user, UpdateUserRequest $updateUserRequest, UpdateUserAction $updateUserAction): ?User
    {
        return $updateUserAction->execute($user, $updateUserRequest->validated());
    }

    /**
     * Destroy the user
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $user->delete();

        return response()->json(["User $user->name successfully destroyed"], 204);
    }
}
