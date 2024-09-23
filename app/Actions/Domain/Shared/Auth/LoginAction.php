<?php

namespace App\Actions\Domain\Shared\Auth;

use App\Models\User;

class LoginAction
{
    public function execute(string $domain, array $inputs) : ?User
    {
        $inputs['email'] = preg_replace('/\s+/', '',strtolower($inputs['email']));

        if ( ! auth()->guard($domain)->attempt($inputs) ) return null;

        $user = auth()->guard($domain)->user();

        $user['token'] = $user->createToken('auth_token')->plainTextToken;

        return $user;
    }

    public function autoLoginFromUser(User $user)
    {
        $user['token'] = $user->createToken('auth_token')->plainTextToken;

        return $user;
    }
}
