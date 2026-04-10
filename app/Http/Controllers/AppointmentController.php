<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Appointment::with(['pet', 'owner']);

        // Role-based filtering
        if ($user->role === 'owner') {
            $query->where('user_id', $user->id);
        }

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('pet', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('owner', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $appointments = $query->orderBy('appointment_date', 'asc')
                              ->orderBy('appointment_time', 'asc')
                              ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->role === 'owner') {
            $pets = $user->pets;
        } else {
            $pets = \App\Models\Pet::all();
        }
        
        $owners = \App\Models\User::where('role', 'owner')->get();
        return view('appointments.create', compact('pets', 'owners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'service_type' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Double-booking check: same date and time
        $exists = Appointment::where('appointment_date', $validated['appointment_date'])
                             ->where('appointment_time', $validated['appointment_time'])
                             ->where('status', '!=', 'cancelled')
                             ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['appointment_time' => 'This time slot is already booked. Please choose another time.']);
        }

        $appointment = Appointment::create($validated);
        ActivityLog::log('Booked Appointment', "Booked appointment for {$appointment->pet->name} on {$appointment->appointment_date}", $appointment);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $owners = \App\Models\User::where('role', 'owner')->get();
        $pets = \App\Models\Pet::all();
        return view('appointments.edit', compact('appointment', 'owners', 'pets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'service_type' => 'required|string|max:255',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Double-booking check (excluding current appointment)
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

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        ActivityLog::log('Cancelled Appointment', "Cancelled appointment ID {$appointment->id}");
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
