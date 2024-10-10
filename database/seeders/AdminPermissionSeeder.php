<?php

namespace Database\Seeders;

use App\Models\Domain\Admin\AdminUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'website crm',
            'candidate',
            'employer',
            'settings',
            'general settings',
            'user management',
        ];

        collect($permissions)->map(fn($permission) => Permission::create(['name' => $permission, 'guard_name' => 'admin']));

        AdminUser::first()?->syncRoles(['super_admin']);

        AdminUser::all()->map(function($admin) use($permissions) {
            $admin->hasRole('super_admin') && $admin->syncPermissions($permissions);
        });
    }
}
