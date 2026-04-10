<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'pet_id',
        'user_id',
        'appointment_date',
        'appointment_time',
        'service_type',
        'status',
        'notes',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
