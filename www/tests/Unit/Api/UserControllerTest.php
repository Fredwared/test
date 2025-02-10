<?php

namespace Tests\Unit\Api;

use App\Enums\RolesEnum;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * @see UserController::me()
     * @return void
     */
    public function test_user_can_own_view_detail()
    {
        $user = User::factory()->create();

        $request = $this->actingAs($user)->get(route('me'));

        $request->assertSuccessful();

        $response = $request->json();

        $this->assertEquals(Arr::get($response, 'data.email'), $user->email);
    }


    /**
     * @see UserController::index()
     * @return void
     */
    public function test_get_user_list_by_administrator()
    {
        $user = User::factory()->create();
        $user->assignRole(RolesEnum::ADMINISTRATOR->value);

        $request = $this->actingAs($user)->get(route('users.index'));

        $request->assertSuccessful();
    }

    /**
     * @see UserController::index()
     * @return void
     */
    public function test_user_cannot_get_users_list()
    {
        $user = User::factory()->create();

        $request = $this->actingAs($user)->get(route('users.index'));

        $request->assertStatus(403);
    }



    /**
     * @see UserController::show()
     * @return void
     */
    public function test_user_show_user_for_admin()
    {
        $user = User::factory()->create();

        $request = $this->actingAs($user)->get(route('users.show', $user));

        $request->assertStatus(403);

        $user->assignRole(RolesEnum::ADMINISTRATOR->value);

        $request = $this->actingAs($user)->get(route('users.show', $user));
        $request->assertSuccessful();
    }


    /**
     * @see UserController::show()
     * @return void
     */
    public function test_update_user_by_admin()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'test name',
            'email' => 'test@example.com'
        ];

        $request = $this->actingAs($user)->patch(route('users.update', $user), $updateData);

        $request->assertStatus(403);

        $admin = User::factory()->create();
        $admin->assignRole(RolesEnum::ADMINISTRATOR->value);

        $request = $this->actingAs($admin)->patch(route('users.update', $user), $updateData);

        $request->assertSuccessful();
    }


    /**
     * @see UserController::show()
     * @return void
     */
    public function test_delete_user_by_admin()
    {
        $user = User::factory()->create();

        $request = $this->actingAs($user)->delete(route('users.destroy', $user));
        $request->assertStatus(403);

        $admin = User::factory()->create();
        $admin->assignRole(RolesEnum::ADMINISTRATOR->value);

        $request = $this->actingAs($admin)->delete(route('users.destroy', $user));

        $request->assertSuccessful();
        $request->assertStatus(204);
    }
}
