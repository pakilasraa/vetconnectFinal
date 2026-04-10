<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'owner') {
            $records = MedicalRecord::whereHas('pet', function($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->with(['pet', 'vet'])->orderBy('visit_date', 'desc')->get();
        } else {
            $records = MedicalRecord::with(['pet', 'vet'])->orderBy('visit_date', 'desc')->get();
        }

        return view('medical-records.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->role === 'owner') {
            abort(403);
        }

        $pets = \App\Models\Pet::with('owner')->get();
        $vets = \App\Models\User::whereIn('role', ['admin', 'staff', 'vet'])->get();

        return view('medical-records.create', compact('pets', 'vets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role === 'owner') {
            abort(403);
        }

        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'vet_id' => 'required|exists:users,id',
            'visit_date' => 'required|date',
            'diagnosis' => 'required|string',
            'treatment' => 'nullable|string',
            'prescription' => 'nullable|string',
        ]);

        $record = MedicalRecord::create($validated);
        ActivityLog::log('Added Medical Record', "Added medical record for pet '{$record->pet->name}'", $record);

        return redirect()->route('medical-records.index')->with('success', 'Medical record added successfully.');
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        if (auth()->user()->role === 'owner') {
            abort(403);
        }

        $pets = \App\Models\Pet::all();
        $vets = \App\Models\User::whereIn('role', ['admin', 'staff', 'vet'])->get();

        return view('medical-records.edit', compact('medicalRecord', 'pets', 'vets'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        if (auth()->user()->role === 'owner') {
            abort(403);
        }

        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'vet_id' => 'required|exists:users,id',
            'visit_date' => 'required|date',
            'diagnosis' => 'required|string',
            'treatment' => 'nullable|string',
            'prescription' => 'nullable|string',
        ]);

        $medicalRecord->update($validated);
        ActivityLog::log('Updated Medical Record', "Updated medical record for pet '{$medicalRecord->pet->name}'", $medicalRecord);

        return redirect()->route('medical-records.index')->with('success', 'Medical record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        if (auth()->user()->role === 'owner') {
            abort(403);
        }

        ActivityLog::log('Deleted Medical Record', "Deleted medical record ID {$medicalRecord->id}");
        $medicalRecord->delete();
        return back()->with('success', 'Medical record deleted successfully.');
    }
}
