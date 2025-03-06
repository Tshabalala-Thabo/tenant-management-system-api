<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Site;

class SiteSeeder extends Seeder
{
    public function run()
    {
        // Sites for Thabo (Landlord ID: 1)
        Site::create([
            'name' => 'Thabo Heights',
            'description' => 'Modern apartment complex in the heart of the city',
            'landlord_id' => 1,
            'address_line1' => '123 Main Street',
            'address_line2' => 'Building A',
            'city' => 'Johannesburg',
            'postal_code' => '2000'
        ]);

        Site::create([
            'name' => 'Tshabalala Residences',
            'description' => 'Student accommodation near university',
            'landlord_id' => 1,
            'address_line1' => '45 University Road',
            'address_line2' => 'Block B',
            'city' => 'Pretoria',
            'postal_code' => '0002'
        ]);

        // Sites for Chris (Landlord ID: 2)
        Site::create([
            'name' => 'Mukwevho Manor',
            'description' => 'Luxury residential complex with modern amenities',
            'landlord_id' => 2,
            'address_line1' => '78 Park Avenue',
            'address_line2' => 'Suite 100',
            'city' => 'Sandton',
            'postal_code' => '2196'
        ]);

        Site::create([
            'name' => 'Chris Commons',
            'description' => 'Affordable housing complex with great location',
            'landlord_id' => 2,
            'address_line1' => '15 Central Road',
            'city' => 'Randburg',
            'postal_code' => '2194'
        ]);
    }
}