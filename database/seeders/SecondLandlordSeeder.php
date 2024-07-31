<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class SecondLandlordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the landlord role if it doesn't exist
        $role = Role::firstOrCreate(['name' => 'landlord']);

        // Assign the landlord role to the user with ID 7
        $user = User::find(7);
        if ($user) {
            $user->assignRole($role);
        }
    }
}
