<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\View\View;

class ClientDashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $stats = [
            'total_pets' => $user->pets()->count(),
            'upcoming_appointments' => Appointment::where('user_id', $user->id)
                ->whereDate('appointment_date', '>=', today())
                ->whereNotIn('status', ['cancelled', 'completed'])
                ->count(),
            'total_records' => MedicalRecord::whereHas('pet', function ($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->count(),
        ];

        $pets = $user->pets()->latest()->take(6)->get();

        $upcomingAppointments = Appointment::with('pet')
            ->where('user_id', $user->id)
            ->whereDate('appointment_date', '>=', today())
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        $recentRecords = MedicalRecord::with(['pet', 'vet'])
            ->whereHas('pet', function ($query) use ($user) {
                $query->where('owner_id', $user->id);
            })
            ->latest('visit_date')
            ->take(5)
            ->get();

        return view('client.client-dashboard.ClientDashboard', compact(
            'stats',
            'pets',
            'upcomingAppointments',
            'recentRecords'
        ));
    }
}
