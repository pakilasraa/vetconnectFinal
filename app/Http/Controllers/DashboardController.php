<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Pet;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $newPetsToday = Pet::whereDate('created_at', Carbon::today())->count();
        $totalConsultations = MedicalRecord::count();
        $activePetOwners = User::where('role', 'pet_owner')->distinct()->count();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $upcomingAppointments = Appointment::with(['pet', 'owner'])
            ->whereBetween('appointment_date', [$startOfWeek, $endOfWeek])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->appointment_date)->format('D d');
            });

        $recentConsultations = MedicalRecord::with(['pet', 'vet'])
            ->latest('visit_date')
            ->take(5)
            ->get();

        $recentLogs = ActivityLog::with('user')->latest()->take(5)->get();

        $recentPets = Pet::with('owner')->latest()->take(5)->get();

        $months = [];
        $appointmentData = [];
        $consultationData = [];
        $growthData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M');
            $months[] = $monthName;

            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $apptCount = Appointment::whereBetween('appointment_date', [$monthStart, $monthEnd])->count();
            $consCount = MedicalRecord::whereBetween('visit_date', [$monthStart, $monthEnd])->count();

            $appointmentData[] = $apptCount;
            $consultationData[] = $consCount;
            $growthData[] = $apptCount + $consCount;
        }

        $performanceAnalysis = [
            'months' => $months,
            'appointments' => $appointmentData,
            'consultations' => $consultationData,
            'growth' => $growthData,
        ];

        $petRegistrations = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $petRegistrations[] = Pet::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        }

        $totalVaccinations = \App\Models\VaccinationRecord::count();
        $completedVaccinations = \App\Models\VaccinationRecord::where('status', 'Completed')->count();
        $vaccinationRate = $totalVaccinations > 0 ? round(($completedVaccinations / $totalVaccinations) * 100) : 0;

        $vaccinationTrend = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $vaccinationTrend[] = \App\Models\VaccinationRecord::whereDate('administered_date', $date)->count();
        }

        $ongoingTreatments = Appointment::with('pet')
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('appointment_date', '>=', Carbon::today())
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'todayAppointments',
            'newPetsToday',
            'totalConsultations',
            'activePetOwners',
            'upcomingAppointments',
            'recentConsultations',
            'recentLogs',
            'recentPets',
            'performanceAnalysis',
            'petRegistrations',
            'vaccinationRate',
            'vaccinationTrend',
            'ongoingTreatments'
        ));
    }
}
