<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'dashboard.view',
            'profile.view',
            'profile.update',
            'profile.delete',
            'clients.view',
            'clients.create',
            'clients.update',
            'clients.delete',
            'client_passwords.view',
            'client_passwords.create',
            'client_passwords.update',
            'client_passwords.delete',
            'financial_data.view',
            'financial_data.create',
            'financial_data.update',
            'financial_data.delete',
            'import.view',
            'import.create',
            'audit_logs.view',
            'notices.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::pluck('name')->all());
    }
}
