<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SecondLandlordSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);
        $this->call([
            TenantsSeeder::class,
        ]);
        $this->call([
            SecondLandlordSeeder::class,
        ]);
        $this->call([
            UnassignRoleSeeder::class,
        ]);
    }

}
