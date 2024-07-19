<?php

namespace App\Actions\Domain\Shared\AccountSetting;

use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    public function execute(string $password): bool
    {
        $user = auth()->user();

        return $user->update(['password' =>Hash::make($password)]);
    }
}
