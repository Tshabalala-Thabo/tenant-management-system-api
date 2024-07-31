<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UnassignRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Find the user with ID 7
        $user = User::find(7);

        // Check if the user exists
        if ($user) {
            // Remove the landlord role from the user
            $user->removeRole('tenant');
        }
    }
}
