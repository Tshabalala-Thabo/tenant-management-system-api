<?php

namespace App\Providers\database\seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Landlords
        $user = User::create([
            'name' => 'Thabo', // Replace with the desired name
            'last_name' => 'Tshabalala', // Replace with the desired last name
            'email' => '47thabo@gmail.com', // Replace with the desired email
            'id_number' => '23423479237832', //
            'phone' => '0745103359', //
            'password' => Hash::make('password'), // Replace with the desired password
        ]);

        $user = User::create([
            'name' => 'Chris', // Replace with the desired name
            'last_name' => 'Mukwevho', // Replace with the desired last name
            'email' => 'chris@gmail.com', // Replace with the desired email
            'id_number' => '23423479237812', //
            'phone' => '0745103359', //
            'password' => Hash::make('password'), // Replace with the desired password
        ]);

        //Service providers
        $user = User::create([
            'name' => 'Shane', // Replace with the desired name
            'last_name' => 'Cooper', // Replace with the desired last name
            'email' => 'shane@gmail.com', // Replace with the desired email
            'id_number' => '23423179237812', //
            'phone' => '0745103359', //
            'password' => Hash::make('password'), // Replace with the desired password
        ]);
        $user = User::create([
            'name' => 'Gontse', // Replace with the desired name
            'last_name' => 'Maluleka', // Replace with the desired last name
            'email' => 'gontse@gmail.com', // Replace with the desired email
            'id_number' => '234247479237812', //
            'phone' => '0745103359', //
            'password' => Hash::make('password'), // Replace with the desired password
        ]);
        $user = User::create([
            'name' => 'Lucky', // Replace with the desired name
            'last_name' => 'Hans', // Replace with the desired last name
            'email' => 'lucky@gmail.com', // Replace with the desired email
            'id_number' => '234234792374444', //
            'phone' => '0745103359', //
            'password' => Hash::make('password'), // Replace with the desired password
        ]);

        // Tenants
        $user = User::create([
            'name' => 'Mary', // Replace with the desired name
            'last_name' => 'Masilela', // Replace with the desired last name
            'email' => 'mary@gmail.com', // Replace with the desired email
            'id_number' => '23426579237812', //
            'phone' => '0745103359', //
            'password' => Hash::make('password'), // Replace with the desired password
        ]);
        $user = User::create([
            'name' => 'Chimugaramafatha', // Replace with the desired name
            'last_name' => 'Osass', // Replace with the desired last name
            'email' => 'osass@gmail.com', // Replace with the desired email
            'id_number' => '23422279237812', //
            'phone' => '0745103359', //
            'password' => Hash::make('password'), // Replace with the desired password
        ]);
        $user = User::create([
            'name' => 'Solly', // Replace with the desired name
            'last_name' => 'Makamu', // Replace with the desired last name
            'email' => 'solly@gmail.com', // Replace with the desired email
            'id_number' => '20323479237812', //
            'phone' => '0745103359', //
            'password' => Hash::make('password'), // Replace with the desired password
        ]);
        $user = User::create([
            'name' => 'Timmy', // Replace with the desired name
            'last_name' => 'Turner', // Replace with the desired last name
            'email' => 'timmy@gmail.com', // Replace with the desired email
            'id_number' => '23423479200312', //
            'phone' => '0745103359', //
            'password' => Hash::make('password'), // Replace with the desired password
        ]);
        $user = User::create([
            'name' => 'Ben', // Replace with the desired name
            'last_name' => 'Sono', // Replace with the desired last name
            'email' => 'ben@gmail.com', // Replace with the desired email
            'id_number' => '90423479237812', //
            'phone' => '0745103359', //
            'password' => Hash::make('password'), // Replace with the desired password
        ]);

    }
}
