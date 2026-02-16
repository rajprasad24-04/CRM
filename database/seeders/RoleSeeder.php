<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = ['admin', 'manager', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $admin = User::where('email', 'admin@wealixir.com')->first();
        if ($admin) {
            $admin->syncRoles(['admin']);
        }

        User::doesntHave('roles')->each(function (User $user) {
            $user->assignRole('user');
        });
    }
}
