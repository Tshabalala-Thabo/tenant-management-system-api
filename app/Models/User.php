<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
use HasRoles, HasApiTokens, HasFactory, Notifiable;

protected $fillable = [
'name',
'last_name',
'email',
'password',
'idno',
'phone'
];

protected $hidden = [
'password',
'remember_token',
];

protected $casts = [
'email_verified_at' => 'datetime',
];

public function sites()
{
return $this->hasMany(Site::class, 'landlord_id');
}

public function leaseAgreements()
{
return $this->hasMany(LeaseAgreement::class, 'tenant_id');
}

public function providedTickets()
{
return $this->hasMany(Ticket::class, 'provider_id');
}

public function invoices()
{
return $this->hasMany(Invoice::class, 'tenant_id');
}

public function tenantTickets()
{
return $this->hasMany(Ticket::class, 'tenant_id');
}

public function rooms()
{
return $this->hasMany(Room::class);
}

// Relationship for many-to-many with sites
public function serviceProviderSites()
{
return $this->belongsToMany(Site::class, 'service_provider_site', 'service_provider_id', 'site_id');
}
}
