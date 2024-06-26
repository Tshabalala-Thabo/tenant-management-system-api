<?php
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Create roles and permissions
$role = Role::create(['name' => 'landlord']);
$permission = Permission::create(['name' => 'edit sites']);

// Assign permission to role
$role->givePermissionTo($permission);

// Assign role to user
$user = User::find(1);
$user->assignRole('landlord');

// Assign permission directly to user
$user->givePermissionTo('edit sites');
