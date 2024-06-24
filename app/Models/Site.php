<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    //use HasFactory;
    protected $fillable = [
        'name', 'description', 'landlord_id',
    ];

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id'); // Assuming User model for landlords
    }
}
