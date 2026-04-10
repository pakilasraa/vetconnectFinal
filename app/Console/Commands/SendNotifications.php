<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automated appointment reminders and vaccination alerts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for notifications...');

        // 1. Appointment Reminders (24 hours before)
        $tomorrow = now()->addDay()->toDateString();
        $appointments = \App\Models\Appointment::where('appointment_date', $tomorrow)
            ->where('status', 'confirmed')
            ->get();

        foreach ($appointments as $appointment) {
            $this->logNotification(
                $appointment->user_id,
                'Appointment Reminder',
                "Reminder: Appointment for {$appointment->pet->name} tomorrow at {$appointment->appointment_time}.",
                $appointment
            );
        }

        // 2. Vaccination Alerts (7 days before)
        $vaxDueDate = now()->addDays(7)->toDateString();
        $vaccinations = \App\Models\VaccinationRecord::where('due_date', $vaxDueDate)
            ->where('status', 'pending')
            ->get();

        foreach ($vaccinations as $vax) {
            $this->logNotification(
                $vax->pet->owner_id,
                'Vaccination Alert',
                "Alert: Vaccination '{$vax->vaccine_name}' for {$vax->pet->name} is due in 7 days.",
                $vax
            );
        }

        $this->info('Notifications processed.');
    }

    private function logNotification($userId, $action, $description, $model)
    {
        \App\Models\ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'model_type' => get_class($model),
            'model_id' => $model->id,
        ]);
        $this->line("Logged: {$action} for User ID {$userId}");
    }
}
