<?php

namespace App\Actions\Domain\Admin\UserManagement\Role;

use Spatie\Permission\Models\Role;

class UpdateRoleAction
{
    public function execute(Role $role, string $newRole, array $permissions = null): ?Role
    {
        if ( $role->name == 'super_admin' ) return $role;

        $role->update(['name' => str($newRole)->snake()]);

        $role->syncPermissions($permissions);

        return $role->refresh();
    }
}
