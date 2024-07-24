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
        $landlordRole = Role::firstOrCreate(['name' => 'landlord']);
        $tenantRole = Role::firstOrCreate(['name' => 'tenant']);

        // Create permissions
        $viewSitesPermission = Permission::firstOrCreate(['name' => 'view sites']);
        $editSitesPermission = Permission::firstOrCreate(['name' => 'edit sites']);

        // Output the permissions to verify they were created
        $this->command->info("Permissions: view sites - {$viewSitesPermission->id}, edit sites - {$editSitesPermission->id}");

        // Assign permissions to roles
        $landlordRole->givePermissionTo($viewSitesPermission);
        $landlordRole->givePermissionTo($editSitesPermission);

        // Output the roles to verify the permissions were assigned
        $this->command->info("Role landlord permissions: " . json_encode($landlordRole->permissions->pluck('name')));

        // Assign roles to users
        $user1 = User::find(2); // Replace with actual user ID
        if ($user1) {
            $user1->assignRole('tenant');
            $this->command->info("User 2 assigned to landlord role");
        }

        $user1 = User::find(3); // Replace with actual user ID
        if ($user1) {
            $user1->assignRole('tenant');
            $this->command->info("User 2 assigned to landlord role");
        }

        $user2 = User::find(1); // Replace with actual user ID
        if ($user2) {
            $user2->assignRole('landlord');
            $this->command->info("User 1 assigned to landlord role");
        }
    }
}
