<?php

namespace Tests\Unit\Api;

use App\Http\Controllers\Api\AuthController;
use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * @see AuthController::register()
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $user = User::factory()->make()->toArray();

        $response = $this->postJson(route('auth.register'), array_merge($user, [
            'password' => 'password',
        ]));

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
        ]);
    }

    /**
     * @see AuthController::register()
     *
     * @return void
     */
    public function test_user_cannot_register_with_existing_email()
    {
        $existingUser = User::factory()->create();

        $response = $this->postJson(route('auth.register'), [
            'name' => 'Does not matter',
            'email' => $existingUser->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token']);
    }

    /**
     * @see AuthController::login()
     *
     * @return void
     */
    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->make();

        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password1111',
        ]);

        $response->assertStatus(401);
    }
}
