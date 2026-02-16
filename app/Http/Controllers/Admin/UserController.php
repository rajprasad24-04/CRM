<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('name')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->pluck('name');
        $permissions = Permission::orderBy('name')->pluck('name');
        $permissionGroups = $this->permissionGroups();

        return view('admin.users.create', compact('roles', 'permissions', 'permissionGroups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,manager,user'],
            'permissions' => ['array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);
        if (!empty($validated['permissions'])) {
            $user->syncPermissions($validated['permissions']);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->pluck('name');
        $permissions = Permission::orderBy('name')->pluck('name');
        $currentRole = $user->roles->first()?->name;
        $currentPermissions = $user->permissions->pluck('name')->all();
        $permissionGroups = $this->permissionGroups();

        return view('admin.users.edit', compact('user', 'roles', 'currentRole', 'permissions', 'currentPermissions', 'permissionGroups'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,manager,user'],
            'permissions' => ['array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        $user->syncRoles([$validated['role']]);
        $user->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    private function permissionGroups(): array
    {
        return [
            'Dashboard' => ['dashboard.view'],
            'Profile' => ['profile.view', 'profile.update', 'profile.delete'],
            'Clients' => ['clients.view', 'clients.create', 'clients.update', 'clients.delete'],
            'Client Passwords' => ['client_passwords.view', 'client_passwords.create', 'client_passwords.update', 'client_passwords.delete'],
            'Financial Data' => ['financial_data.view', 'financial_data.create', 'financial_data.update', 'financial_data.delete'],
            'Import' => ['import.view', 'import.create'],
            'Notices' => ['notices.manage'],
        ];
    }
}
