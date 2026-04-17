<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RedirectsToPanelRoute;
use App\Models\ActivityLog;
use App\Models\Appointment;
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
