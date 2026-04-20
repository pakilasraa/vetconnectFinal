<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;

class MedicalRecordPolicy
{
    /**
     * Determine if the user can view the medical record.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MedicalRecord  $record
     * @return bool
     */
    public function view(User $user, MedicalRecord $record)
    {
        // Check if the medical record belongs to one of the user's pets
        return $record->pet->user_id === $user->id;
    }
}
