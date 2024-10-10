<?php

namespace Database\Seeders;

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
    }
}
