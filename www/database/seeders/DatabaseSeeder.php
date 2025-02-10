<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::query()->create(['name' => RolesEnum::ADMINISTRATOR->value]);

        $admin = User::factory()->create([ // Administrator
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $admin->assignRole(RolesEnum::ADMINISTRATOR->value);
    }
}
