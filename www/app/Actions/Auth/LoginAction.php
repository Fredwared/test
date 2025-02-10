<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function execute(array $data)
    {
        if (! Auth::attempt($data)) {
            return new User;
        }

        return Auth::user();
    }
}
