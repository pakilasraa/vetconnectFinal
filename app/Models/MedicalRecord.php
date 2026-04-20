<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $casts = [
        'visit_date' => 'date',
    ];

    protected $fillable = [
        'pet_id',
        'vet_id',
        'visit_date',
        'diagnosis',
        'treatment',
        'prescription',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function vet()
    {
        return $this->belongsTo(User::class, 'vet_id');
    }
}
