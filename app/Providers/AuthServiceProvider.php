<?php

namespace App\Providers;

use App\Models\Pet;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Policies\PetPolicy;
use App\Policies\AppointmentPolicy;
use App\Policies\MedicalRecordPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Pet::class => PetPolicy::class,
        Appointment::class => AppointmentPolicy::class,
        MedicalRecord::class => MedicalRecordPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
