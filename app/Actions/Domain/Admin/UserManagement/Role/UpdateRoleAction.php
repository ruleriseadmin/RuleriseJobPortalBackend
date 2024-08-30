<?php

namespace App\Actions\Domain\Admin\UserManagement\Role;

use Spatie\Permission\Models\Role;

class UpdateRoleAction
{
    public function execute(Role $role, string $newRole): ?Role
    {
        if ( $role->name == 'super_admin' ) return $role;

        $role->update(['name' => str($newRole)->snake()]);

        return $role->refresh();
    }
}
