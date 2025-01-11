<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'site_id',
        'status',
        'termination_reason',
        'rejection_reason',
        'termination_date',
        'rejection_date',
        'previously_terminated',
        'previously_rejected',
    ];

    /**
     * Relationships
     */
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id'); // Assuming User model for tenants
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    /**
     * Scope for filtering terminated or rejected applications
     */
    public function scopeTerminated($query)
    {
        return $query->where('status', 'terminated');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Check if the application has been terminated previously
     */
    public function wasTerminated()
    {
        return $this->previously_terminated;
    }

    /**
     * Check if the application has been rejected previously
     */
    public function wasRejected()
    {
        return $this->previously_rejected;
    }
}
