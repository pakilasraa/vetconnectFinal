<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isOwner = $user->role === 'owner';

        // 1. Counters
        if ($isOwner) {
            $todayAppointments = Appointment::where('user_id', $user->id)
                ->whereDate('appointment_date', Carbon::today())
                ->count();
            
            $newPetsToday = Pet::where('owner_id', $user->id)
                ->whereDate('created_at', Carbon::today())
                ->count();
            
            $totalConsultations = MedicalRecord::whereHas('pet', function($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->count();

            $activePetOwners = 1; 
        } else {
            $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
            $newPetsToday = Pet::whereDate('created_at', Carbon::today())->count();
            $totalConsultations = MedicalRecord::count();
            $activePetOwners = User::where('role', 'owner')->distinct()->count();
        }

        // 2. Upcoming Appointments for this week (grouped by day)
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $upcomingQuery = Appointment::with(['pet', 'owner'])
            ->whereBetween('appointment_date', [$startOfWeek, $endOfWeek])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time');

        if ($isOwner) {
            $upcomingQuery->where('user_id', $user->id);
        }
        
        $upcomingAppointments = $upcomingQuery->get()->groupBy(function($date) {
            return Carbon::parse($date->appointment_date)->format('D d');
        });

        // 3. Recent Medical Consultations
        $consultationsQuery = MedicalRecord::with(['pet', 'vet'])
            ->latest('visit_date')
            ->take(5);

        if ($isOwner) {
            $consultationsQuery->whereHas('pet', function($query) use ($user) {
                $query->where('owner_id', $user->id);
            });
        }
        $recentConsultations = $consultationsQuery->get();

        // 4. Clinic Activity Logs
        $activityLogQuery = ActivityLog::with('user')->latest()->take(5);
        if ($isOwner) {
            $activityLogQuery->where('user_id', $user->id);
        }
        $recentLogs = $activityLogQuery->get();

        // 5. Recent Pet Registrations
        $petQuery = Pet::with('owner')->latest()->take(5);
        if ($isOwner) {
            $petQuery->where('owner_id', $user->id);
        }
        $recentPets = $petQuery->get();

        // 6. Chart Data: Clinic Performance Analysis (Last 6 Months)
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

            $appointmentsCount = Appointment::whereBetween('appointment_date', [$monthStart, $monthEnd]);
            $consultationsCount = MedicalRecord::whereBetween('visit_date', [$monthStart, $monthEnd]);

            if ($isOwner) {
                $appointmentsCount->where('user_id', $user->id);
                $consultationsCount->whereHas('pet', function($q) use ($user) { $q->where('owner_id', $user->id); });
            }

            $apptCount = $appointmentsCount->count();
            $consCount = $consultationsCount->count();

            $appointmentData[] = $apptCount;
            $consultationData[] = $consCount;
            $growthData[] = $apptCount + $consCount; // Simplified growth metric
        }

        $performanceAnalysis = [
            'months' => $months,
            'appointments' => $appointmentData,
            'consultations' => $consultationData,
            'growth' => $growthData
        ];

        // 7. Chart Data: Active Pet Owners (New registrations by month)
        $petRegistrations = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $count = Pet::whereBetween('created_at', [$monthStart, $monthEnd]);
            if ($isOwner) {
                $count->where('owner_id', $user->id);
            }
            $petRegistrations[] = $count->count();
        }

        // 8. Vaccination Overview
        $totalVaccinations = \App\Models\VaccinationRecord::count();
        $completedVaccinations = \App\Models\VaccinationRecord::where('status', 'Completed')->count();
        $vaccinationRate = $totalVaccinations > 0 ? round(($completedVaccinations / $totalVaccinations) * 100) : 0;
        
        // Vaccination trend (last 12 days for sparkle chart)
        $vaccinationTrend = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $vaccinationTrend[] = \App\Models\VaccinationRecord::whereDate('administered_date', $date)->count();
        }

        // 9. Ongoing Treatments (Simulated: Pending appointments or recent records)
        $ongoingTreatments = Appointment::with('pet')
            ->whereIn('status', ['Pending', 'Confirmed'])
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
