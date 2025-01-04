<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    //use HasFactory;
    protected $fillable = [
        'name', 'description', 'landlord_id', 'address_line1', 'address_line2', 'city', 'postal_code'
    ];

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id'); // Assuming User model for landlords
    }
    public function rooms()
    {
        return $this->hasMany(Room::class, 'site_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'site_id');
    }
    public function serviceProviders()
    {
        return $this->belongsToMany(User::class, 'service_provider_site', 'site_id', 'service_provider_id');
    }

    // Helper method to get full address
    public function getFullAddressAttribute()
    {
        $address_parts = array_filter([
            $this->address_line1,
            $this->address_line2,
            $this->city,
            $this->postal_code
        ]);
        
        return implode(', ', $address_parts);
    }
}

