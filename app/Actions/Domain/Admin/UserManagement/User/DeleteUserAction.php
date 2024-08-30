<?php

namespace App\Actions\Domain\Admin\UserManagement\User;

use App\Models\Domain\Admin\AdminUser;

class DeleteUserAction
{
    public function execute(AdminUser $user)
    {
        $mainSystemAdmin = AdminUser::first();

        if ( $mainSystemAdmin->id == $user->id ) return false;

        return $user->delete();
    }
}
