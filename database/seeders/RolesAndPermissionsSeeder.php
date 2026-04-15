<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('permission:cache-reset');

        $permissions = [
            'manage-users',
            'manage-roles',
            'manage-permissions',
            'manage-experiences',
            'manage-projects',
            'manage-contacts',
            'manage-home',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);

        $admin->syncPermissions($permissions);
        $editor->syncPermissions([
            'manage-experiences',
            'manage-projects',
            'manage-contacts',
            'manage-home',
        ]);
    }
}
