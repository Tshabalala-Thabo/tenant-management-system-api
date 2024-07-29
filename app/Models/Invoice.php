<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'room_id',
        'site_id',
        'issue_date',
        'due_date',
        'amount',
        'paid_amount',
        'status',
        'water_charge',
        'electricity_charge',
        'other_charges',
        'description',
    ];

    // Define relationships
    public function tenant()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    // Define any additional methods or scopes as needed
}
