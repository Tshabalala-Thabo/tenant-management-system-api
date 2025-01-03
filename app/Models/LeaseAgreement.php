<?php
// app/Models/LeaseAgreement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaseAgreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'tenant_id',
        'start_date',
        'end_date',
        'is_terminated',
        'termination_date'
    ];

    protected $casts = [
        'is_terminated' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'termination_date' => 'datetime'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }
}
