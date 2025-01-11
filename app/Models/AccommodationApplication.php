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
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id'); // Assuming User model for tenants
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
} 