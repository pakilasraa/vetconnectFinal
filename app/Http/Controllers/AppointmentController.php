<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RedirectsToPanelRoute;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Support\AppointmentSlots;
use Carbon\Carbon;
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

            return view('client.client-appointment.ClientAppointment', compact('appointments', 'filter'));
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
        }

        $appointments = $query->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    public function calendar(Request $request): View
    {
        $windowStart = now()->subMonths(2)->startOfMonth();
        $windowEnd = now()->addMonths(6)->endOfMonth();

        $appointments = Appointment::with(['pet', 'owner'])
            ->whereBetween('appointment_date', [$windowStart->toDateString(), $windowEnd->toDateString()])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $events = $appointments->map(function (Appointment $a) {
            $date = Carbon::parse($a->appointment_date)->format('Y-m-d');
            $time = (string) $a->appointment_time;
            if (strlen($time) === 5) {
                $time .= ':00';
            }
            $start = Carbon::parse("{$date} {$time}");
            $end = $start->copy()->addMinutes(45);

            [$background, $border] = match ($a->status) {
                'confirmed' => ['#22C03C', '#1a9a30'],
                'completed' => ['#6b7280', '#4b5563'],
                'cancelled' => ['#dc2626', '#b91c1c'],
                default => ['#0d6efd', '#0a58ca'],
            };

            return [
                'id' => (string) $a->id,
                'title' => $a->pet->name.' · '.$a->service_type,
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
                'backgroundColor' => $background,
                'borderColor' => $border,
                'classNames' => $a->status === 'cancelled' ? ['appointment-cancelled'] : [],
                'extendedProps' => [
                    'editUrl' => route('admin.appointments.edit', $a),
                    'owner' => $a->owner->name,
                    'status' => $a->status,
                    'dayLabel' => $start->translatedFormat('l, M j, Y'),
                    'timeLabel' => $start->format('g:i A'),
                    'notes' => $a->notes,
                ],
            ];
        })->values();

        $activity = $appointments
            ->sortBy(fn (Appointment $a) => Carbon::parse($a->appointment_date)->toDateString().' '.$a->appointment_time)
            ->take(25)
            ->values();

        return view('appointments.calendar', compact('events', 'activity'));
    }

    public function clientAvailability(Request $request): View
    {
        if (! $request->user()->isPetOwner()) {
            abort(404);
        }

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

        $prev = $monthStart->copy()->subMonth();
        $next = $monthStart->copy()->addMonth();

        return view('client.client-appointment.AvailabilityCalendar', compact(
            'weeks',
            'monthStart',
            'year',
            'month',
            'prev',
            'next',
            'slotCount'
        ));
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

        if ($request->user()->isPetOwner()) {
            $pet = \App\Models\Pet::where('id', $validated['pet_id'])->where('owner_id', $request->user()->id)->first();
            if (! $pet) {
                return back()->withInput()->withErrors(['pet_id' => 'Invalid pet selection.']);
            }
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
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'service_type' => 'required|string|max:255',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($request->user()->isPetOwner()) {
            if (! $request->user()->pets->contains('id', (int) $validated['pet_id'])) {
                return back()->withInput()->withErrors(['pet_id' => 'Invalid pet selection.']);
            }
            $validated['user_id'] = $request->user()->id;
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
