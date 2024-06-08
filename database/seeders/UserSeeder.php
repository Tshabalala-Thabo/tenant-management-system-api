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
            'name' => 'promilezi', // Replace with the desired name
            'last_name' => 'developer', // Replace with the desired last name
            'email' => 'promilezi@gmail.com', // Replace with the desired email
            'password' => Hash::make('developer123#'), // Replace with the desired password
        ]);
    }
}
