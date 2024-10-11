<?php

namespace App\Actions\Domain\Admin\UserManagement\Role;

use Spatie\Permission\Models\Role;

class CreateRoleAction
{
    public function execute(string $role, array $permissions = null): ?Role
    {
        if ( $role == 'super_admin' ) return null;

        $role = Role::create([
            'name' => str($role)->snake(),
            'guard_name' => 'admin',
        ]);

        $role->syncPermissions($permissions);

        return $role;
    }
}
