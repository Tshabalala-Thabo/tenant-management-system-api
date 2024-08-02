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
        $serviceProviderRole = Role::firstOrCreate(['name' => 'service_provider']);

        // Create permissions
        $viewSitesPermission = Permission::firstOrCreate(['name' => 'view sites']);
        $manageSitesPermission = Permission::firstOrCreate(['name' => 'manage sites']);
        $viewInvoicesPermission = Permission::firstOrCreate(['name' => 'view invoices']);
        $viewLeasesPermission = Permission::firstOrCreate(['name' => 'view leases']);

        // Output the permissions to verify they were created
        $this->command->info("Permissions created: view sites (ID: {$viewSitesPermission->id}), edit sites (ID: {$manageSitesPermission->id})");

        // Assign permissions to roles
        $landlordRole->givePermissionTo($viewSitesPermission, $manageSitesPermission, $viewInvoicesPermission, $viewLeasesPermission);
        $tenantRole->givePermissionTo($viewInvoicesPermission, $viewLeasesPermission);
        $serviceProviderRole->givePermissionTo($viewSitesPermission);

        // Output the roles to verify the permissions were assigned
        $this->command->info("Permissions assigned to landlord role: " . json_encode($landlordRole->permissions->pluck('name')));

        // Function to assign roles and log the result
        $assignRole = function($userId, $roleName) {
            $user = User::find($userId);
            if ($user) {
                $user->assignRole($roleName);
                $this->command->info("User {$userId} assigned to {$roleName} role");
            } else {
                $this->command->warn("User {$userId} not found");
            }
        };

        // Assign roles
        $assignRole(1, 'landlord');
        $assignRole(2, 'landlord');
        $assignRole(3, 'service_provider');
        $assignRole(4, 'service_provider');
        $assignRole(5, 'service_provider');
        $assignRole(6, 'tenant');
        $assignRole(7, 'tenant');
        $assignRole(8, 'tenant');
        $assignRole(9, 'tenant');
        $assignRole(10, 'tenant');
    }
}
