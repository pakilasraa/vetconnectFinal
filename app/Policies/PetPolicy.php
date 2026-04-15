<?php

namespace App\Policies;

use App\Models\Pet;
use App\Models\User;

class PetPolicy
{
    /**
     * Determine if the user can view the pet.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pet  $pet
     * @return bool
     */
    public function view(User $user, Pet $pet)
    {
        return $user->id === $pet->user_id;
    }

    /**
     * Determine if the user can update the pet.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pet  $pet
     * @return bool
     */
    public function update(User $user, Pet $pet)
    {
        return $user->id === $pet->user_id;
    }

    /**
     * Determine if the user can delete the pet.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pet  $pet
     * @return bool
     */
    public function delete(User $user, Pet $pet)
    {
        return $user->id === $pet->user_id;
    }
}
