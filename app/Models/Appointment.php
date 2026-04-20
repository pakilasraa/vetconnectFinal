<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->appointment_date)->format('M d, Y');
    }

    /**
     * Alias for client UI templates that refer to appointment "type".
     */
    public function getTypeAttribute(): ?string
    {
        return $this->service_type;
    }
}
