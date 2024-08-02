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
        $editSitesPermission = Permission::firstOrCreate(['name' => 'edit sites']);

        // Output the permissions to verify they were created
        $this->command->info("Permissions: view sites - {$viewSitesPermission->id}, edit sites - {$editSitesPermission->id}");

        // Assign permissions to roles
        $landlordRole->givePermissionTo($viewSitesPermission);
        $landlordRole->givePermissionTo($editSitesPermission);

        // Output the roles to verify the permissions were assigned
        $this->command->info("Role landlord permissions: " . json_encode($landlordRole->permissions->pluck('name')));

        // Assign landlord roles
        $user1 = User::find(1); // Replace with actual user ID
        if ($user1) {
            $user1->assignRole('landlord');
            $this->command->info("User 1 assigned to landlord role");
        }

        $user2 = User::find(2); // Replace with actual user ID
        if ($user2) {
            $user2->assignRole('landlord');
            $this->command->info("User 2 assigned to landlord role");
        }

        // Assign service provider roles
        $user3 = User::find(3); // Replace with actual user ID
        if ($user3) {
            $user3->assignRole('service_provider');
            $this->command->info("User 3 assigned to service p role");
        }
        $user4 = User::find(4); // Replace with actual user ID
        if ($user4) {
            $user4->assignRole('service_provider');
            $this->command->info("User 4 assigned to service p role");
        }
        $user5 = User::find(5); // Replace with actual user ID
        if ($user5) {
            $user5->assignRole('service_provider');
            $this->command->info("User 1 assigned to service p role");
        }
        // Assign tenant roles
        $user6 = User::find(6); // Replace with actual user ID
        if ($user6) {
            $user6->assignRole('tenant');
            $this->command->info("User 6 assigned to tenant role");
        }
        $user7 = User::find(7); // Replace with actual user ID
        if ($user7) {
            $user2->assignRole('tenant');
            $this->command->info("User 7 assigned to tenant role");
        }
        $user8 = User::find(8); // Replace with actual user ID
        if ($user8) {
            $user8->assignRole('tenant');
            $this->command->info("User 8 assigned to tenant role");
        }
        $user9 = User::find(9); // Replace with actual user ID
        if ($user9) {
            $user9->assignRole('tenant');
            $this->command->info("User 9 assigned to tenant role");
        }
        $user10 = User::find(10); // Replace with actual user ID
        if ($user10) {
            $user10->assignRole('tenant');
            $this->command->info("User 10 assigned to tenant role");
        }
    }
}
