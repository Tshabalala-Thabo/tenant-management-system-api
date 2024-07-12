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
    // spatie permissions
    use HasRoles;

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sites()
    {
        return $this->hasMany(Site::class, 'landlord_id');
    }
    public function providedTickets()
    {
        return $this->hasMany(Ticket::class, 'provider_id');
    }

    /**
     * Get the tickets assigned to the user as a tenant.
     */
    public function tenantTickets()
    {
        return $this->hasMany(Ticket::class, 'tenant_id');
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
