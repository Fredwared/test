<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    protected bool $fails = false;

    /**
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function execute(array $data)
    {
        return User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
