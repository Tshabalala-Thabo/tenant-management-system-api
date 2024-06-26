<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Clear the cache to avoid issues with permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // Create roles
        $landlordRole = Role::create(['name' => 'landlord']);
        $tenantRole = Role::create(['name' => 'tenant']);

        // Create permissions (if needed)
        $viewSitesPermission = Permission::create(['name' => 'view sites']);
        $editSitesPermission = Permission::create(['name' => 'edit sites']);


        // Assign permissions to roles
        $landlordRole->givePermissionTo($viewSitesPermission);
        $landlordRole->givePermissionTo($editSitesPermission);

        // Assign roles to users
        $user = User::find(2); // Replace with actual user ID
        if ($user) {
            $user->assignRole('landlord');
        }

        $user = User::find(1); // Replace with actual user ID
        if ($user) {
            $user->assignRole('landlord');
        }
    }
}
