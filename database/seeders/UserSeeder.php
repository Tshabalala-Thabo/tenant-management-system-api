<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
        $user = User::create([
            'name' => 'Thabo', // Replace with the desired name
            'last_name' => 'Tshabalala', // Replace with the desired last name
            'email' => '47thabo@gmail.com', // Replace with the desired email
            'idno' => '23423479237832', // 
            'phone' => '0745103359', // 
            'password' => Hash::make('password'), // Replace with the desired password
        ]);
    }
}
