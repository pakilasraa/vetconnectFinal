<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    /**
     * Determine if the user can view the appointment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Appointment  $appointment
     * @return bool
     */
    public function view(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->user_id;
    }

    /**
     * Determine if the user can update the appointment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Appointment  $appointment
     * @return bool
     */
    public function update(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->user_id;
    }

    /**
     * Determine if the user can delete the appointment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Appointment  $appointment
     * @return bool
     */
    public function delete(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->user_id;
    }
}
