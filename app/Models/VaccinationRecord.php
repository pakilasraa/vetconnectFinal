<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaccinationRecord extends Model
{
    protected $fillable = [
        'pet_id',
        'vaccine_name',
        'administered_date',
        'due_date',
        'status',
    ];

    protected $casts = [
        'administered_date' => 'date',
        'due_date' => 'date',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
