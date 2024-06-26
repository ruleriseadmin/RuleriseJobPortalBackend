<?php

namespace Database\Seeders;

use App\Supports\RoleSupport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = RoleSupport::getRoles();

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
                'guard_name' => 'admin',
            ]);
            Role::create([
                'name' => $role,
                'guard_name' => 'employer',
            ]);
            // Role::create([
            //     'name' => $role,
            // ]);
        }
    }
}
