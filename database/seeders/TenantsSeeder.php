<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class TenantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Mary', // Replace with the desired name
            'last_name' => 'Masilela', // Replace with the desired last name
            'email' => 'mary@gmail.com', // Replace with the desired email
            'idno' => '2343479237832', // 
            'phone' => '0745103359', // 
            'password' => Hash::make('password'), // Replace with the desired password
        ]);

        $user = User::create([
            'name' => 'Solly', // Replace with the desired name
            'last_name' => 'Makamu', // Replace with the desired last name
            'email' => 'solly@gmail.com', // Replace with the desired email
            'idno' => '2342347927832', // 
            'phone' => '0745103359', // 
            'password' => Hash::make('password'), // Replace with the desired password
        ]);
    }
}
