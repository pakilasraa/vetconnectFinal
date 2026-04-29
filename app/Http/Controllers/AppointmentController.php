<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RedirectsToPanelRoute;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Support\AppointmentSlots;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    use RedirectsToPanelRoute;

    public function index(Request $request): View
    {
        $user = $request->user();
        $query = Appointment::with(['pet', 'owner']);

        if ($user->isPetOwner()) {
            $query->where('user_id', $user->id);
        }

        if ($request->routeIs('client.appointments.*')) {
            $filter = $request->get('filter', 'all');

            if ($filter === 'upcoming') {
                $query->whereDate('appointment_date', '>=', today())
                    ->whereNotIn('status', ['cancelled', 'completed']);
            } elseif ($filter === 'past') {
                $query->where(function ($q) {
                    $q->whereDate('appointment_date', '<', today())
                        ->orWhereIn('status', ['completed', 'cancelled']);
                });
            }

            $appointments = $query->orderBy('appointment_date')->orderBy('appointment_time')->get();

            // Build availability calendar data for the merged page
            $calYear  = max(2000, min(2100, (int) $request->get('cal_year',  now()->year)));
            $calMonth = max(1,    min(12,   (int) $request->get('cal_month', now()->month)));
            $monthStart = Carbon::createFromDate($calYear, $calMonth, 1)->startOfDay();
            $monthEnd   = $monthStart->copy()->endOfMonth();
            $slotCount  = count(AppointmentSlots::times());

            $bookedCounts = Appointment::query()
                ->selectRaw('appointment_date, COUNT(*) as c')
                ->whereBetween('appointment_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
                ->where('status', '!=', 'cancelled')
                ->groupBy('appointment_date')
                ->pluck('c', 'appointment_date');

            $gridStart = $monthStart->copy()->startOfWeek(Carbon::MONDAY);
            $gridEnd   = $monthEnd->copy()->endOfWeek(Carbon::SUNDAY);
            $calWeeks  = [];
            $cursor    = $gridStart->copy();
            $today     = today()->startOfDay();

            while ($cursor->lte($gridEnd)) {
                $week = [];
                for ($i = 0; $i < 7; $i++) {
                    $day     = $cursor->copy();
                    $dateStr = $day->toDateString();
                    $inMonth = $day->month === $calMonth;

                    if (! $inMonth) {
                        $week[] = ['day' => $day, 'in_month' => false, 'status' => 'other', 'date_str' => $dateStr];
                    } elseif ($day->lt($today)) {
                        $week[] = ['day' => $day, 'in_month' => true,  'status' => 'past',  'date_str' => $dateStr];
                    } else {
                        $used   = (int) ($bookedCounts[$dateStr] ?? 0);
                        $status = $used >= $slotCount ? 'full' : 'available';
                        $week[] = ['day' => $day, 'in_month' => true,  'status' => $status, 'date_str' => $dateStr, 'used' => $used, 'total' => $slotCount];
                    }
                    $cursor->addDay();
                }
                $calWeeks[] = $week;
            }

            $calPrev = $monthStart->copy()->subMonth();
            $calNext = $monthStart->copy()->addMonth();

            return view('client.client-appointment.ClientAppointment', compact(
                'appointments', 'filter',
                'calWeeks', 'monthStart', 'calYear', 'calMonth', 'calPrev', 'calNext', 'slotCount'
            ));
        }

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('pet', function ($pq) use ($search) {
                    $pq->where('name', 'like', "%{$search}%");
                })->orWhereHas('owner', function ($oq) use ($search) {
                    $oq->where('name', 'like', "%{$search}%");
                });
            });
        } else {
            $query->whereDate('appointment_date', '>=', today());
        }

        $appointments = $query->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    public function calendar(Request $request): View
    {
        $year = max(2000, min(2100, (int) $request->get('year', now()->year)));
        $month = max(1, min(12, (int) $request->get('month', now()->month)));
        $monthStart = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $monthEnd = $monthStart->copy()->endOfMonth();
        $slotCount = count(AppointmentSlots::times());

        $bookedCounts = Appointment::query()
            ->selectRaw('appointment_date, COUNT(*) as c')
            ->whereBetween('appointment_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->where('status', '!=', 'cancelled')
            ->groupBy('appointment_date')
            ->pluck('c', 'appointment_date');

        $gridStart = $monthStart->copy()->startOfWeek(Carbon::MONDAY);
        $gridEnd = $monthEnd->copy()->endOfWeek(Carbon::SUNDAY);
        $weeks = [];
        $cursor = $gridStart->copy();
        $today = today()->startOfDay();

        while ($cursor->lte($gridEnd)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $day = $cursor->copy();
                $dateStr = $day->toDateString();
                $inMonth = $day->month === $month;

                if (! $inMonth) {
                    $week[] = ['day' => $day, 'in_month' => false, 'status' => 'other', 'date_str' => $dateStr];
                } elseif ($day->lt($today)) {
                    $week[] = ['day' => $day, 'in_month' => true, 'status' => 'past', 'date_str' => $dateStr];
                } else {
                    $used = (int) ($bookedCounts[$dateStr] ?? 0);
                    $status = $used >= $slotCount ? 'full' : 'available';
                    $week[] = ['day' => $day, 'in_month' => true, 'status' => $status, 'date_str' => $dateStr, 'used' => $used, 'total' => $slotCount];
                }

                $cursor->addDay();
            }
            $weeks[] = $week;
        }

        $windowStart = $monthStart->copy()->startOfMonth();
        $windowEnd = $monthStart->copy()->addMonth()->endOfMonth();

        $appointments = Appointment::with(['pet', 'owner'])
            ->whereBetween('appointment_date', [$windowStart->toDateString(), $windowEnd->toDateString()])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $activity = $appointments
            ->sortBy(fn (Appointment $a) => Carbon::parse($a->appointment_date)->toDateString().' '.$a->appointment_time)
            ->take(25)
            ->values();

        $prev = $monthStart->copy()->subMonth();
        $next = $monthStart->copy()->addMonth();

        return view('appointments.calendar', compact(
            'monthStart',
            'prev',
            'next',
            'weeks',
            'slotCount',
            'activity'
        ));
    }

    public function clientAvailability(Request $request): RedirectResponse
    {
        // The availability calendar is now embedded in the appointments page.
        // Redirect old bookmarks/links to the merged appointments page,
        // forwarding year/month as cal_year/cal_month so the right month opens.
        $params = [];
        if ($request->has('year'))  { $params['cal_year']  = $request->get('year'); }
        if ($request->has('month')) { $params['cal_month'] = $request->get('month'); }
        $params['tab'] = 'calendar';

        return redirect()->route('client.appointments.index', $params);
    }

    public function bookedSlots(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'exclude_id' => 'nullable|integer|exists:appointments,id',
        ]);

        $query = Appointment::query()
            ->whereDate('appointment_date', $validated['date'])
            ->where('status', '!=', 'cancelled');

        if (! empty($validated['exclude_id'])) {
            $query->where('id', '!=', $validated['exclude_id']);
        }

        $booked = $query->pluck('appointment_time')
            ->map(function ($time) {
                $time = (string) $time;
                return strlen($time) === 5 ? "{$time}:00" : $time;
            })
            ->values();

        return response()->json([
            'booked' => $booked,
            'slots' => AppointmentSlots::times(),
        ]);
    }

    public function create(Request $request): View
    {
        $user = $request->user();
        if ($user->isPetOwner()) {
            $pets = $user->pets;
            $owners = collect();
        } else {
            $pets = \App\Models\Pet::all();
            $owners = \App\Models\User::where('role', 'pet_owner')->get();
        }

        if ($request->routeIs('client.appointments.*')) {
            return view('client.client-appointment.CreateAppointment', compact('pets', 'owners'));
        }

        return view('appointments.create', compact('pets', 'owners'));
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'pet_id' => 'required|exists:pets,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'service_type' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ];

        if ($request->user()->isAdmin()) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        $validated['user_id'] = $request->user()->isPetOwner()
            ? $request->user()->id
            : $validated['user_id'];

        $pet = \App\Models\Pet::where('id', $validated['pet_id'])
            ->where('owner_id', $validated['user_id'])
            ->first();

        if (! $pet) {
            return back()->withInput()->withErrors(['pet_id' => 'Selected pet does not belong to the selected owner.']);
        }

        $exists = Appointment::where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['appointment_time' => 'This time slot is already booked. Please choose another time.']);
        }

        $appointment = Appointment::create($validated);
        ActivityLog::log('Booked Appointment', "Booked appointment for {$appointment->pet->name} on {$appointment->appointment_date}", $appointment);

        return $this->panelRedirect('appointments.index')->with('success', 'Appointment booked successfully.');
    }

    public function edit(Request $request, Appointment $appointment): View|RedirectResponse
    {
        if ($redirect = $this->ensureAppointmentAccessible($request, $appointment)) {
            return $redirect;
        }

        if ($request->user()->isPetOwner()) {
            $pets = $request->user()->pets;
            $owners = \App\Models\User::where('id', $request->user()->id)->get();
        } else {
            $owners = \App\Models\User::where('role', 'pet_owner')->get();
            $pets = \App\Models\Pet::all();
        }

        if ($request->routeIs('client.appointments.*')) {
            return view('client.client-appointment.EditAppointment', compact('appointment', 'owners', 'pets'));
        }

        return view('appointments.edit', compact('appointment', 'owners', 'pets'));
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($redirect = $this->ensureAppointmentAccessible($request, $appointment)) {
            return $redirect;
        }

        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date', // Relaxed to allow editing past appointments
            'appointment_time' => 'required',
            'service_type' => 'required|string|max:255',
            'status' => 'sometimes|required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($request->user()->isPetOwner()) {
            $validated['user_id'] = $request->user()->id;
        }

        $pet = \App\Models\Pet::where('id', $validated['pet_id'])
            ->where('owner_id', $validated['user_id'])
            ->first();

        if (! $pet) {
            return back()->withInput()->withErrors(['pet_id' => 'Selected pet does not belong to the selected owner.']);
        }

        $exists = Appointment::where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->where('id', '!=', $appointment->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['appointment_time' => 'This time slot is already booked. Please choose another time.']);
        }

        $appointment->update($validated);
        ActivityLog::log('Updated Appointment', "Updated appointment status to {$appointment->status}", $appointment);

        return $this->panelRedirect('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($redirect = $this->ensureAppointmentAccessible($request, $appointment)) {
            return $redirect;
        }

        ActivityLog::log('Cancelled Appointment', "Cancelled appointment ID {$appointment->id}");
        $appointment->delete();

        return $this->panelRedirect('appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    public function cancel(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($redirect = $this->ensureAppointmentAccessible($request, $appointment)) {
            return $redirect;
        }

        $appointment->update(['status' => 'cancelled']);
        ActivityLog::log('Cancelled Appointment', "User cancelled appointment ID {$appointment->id}", $appointment);

        return $this->panelRedirect('appointments.index')->with('success', 'Appointment cancelled.');
    }

    private function ensureAppointmentAccessible(Request $request, Appointment $appointment): ?RedirectResponse
    {
        if ($request->user()->isPetOwner() && $appointment->user_id !== $request->user()->id) {
            return redirect()->route('not-authorized');
        }

        return null;
    }
}
