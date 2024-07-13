<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'details', 'provider_id', 'response', 'tenant_id', 'status', 'room_id', 'site_id'
    // ];
    protected $fillable = [
        'details',
        'provider_id',
        'response',
        'room_id',
        'site_id',
        'tenant_id',
        'status',
    ];

    /**
     * Get the provider of the ticket.
     */
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    /**
     * Get the tenant of the ticket.
     */
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Get the site of the ticket.
     */
    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    /**
     * Get the room of the ticket.
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
