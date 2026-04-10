<?php

namespace App\Http\Controllers;

use App\Models\VaccinationRecord;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class VaccinationRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'owner') {
            $records = VaccinationRecord::whereHas('pet', function($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->with('pet')->orderBy('administered_date', 'desc')->get();
        } else {
            $records = VaccinationRecord::with('pet')->orderBy('administered_date', 'desc')->get();
        }

        return view('vaccination-records.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'owner') {
            abort(403);
        }

        $pets = \App\Models\Pet::all();

        return view('vaccination-records.create', compact('pets'));
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
            'vaccine_name' => 'required|string|max:255',
            'administered_date' => 'required|date',
            'due_date' => 'nullable|date',
            'status' => 'required|in:given,pending',
        ]);

        $record = VaccinationRecord::create($validated);
        ActivityLog::log('Added Vaccination', "Added vaccination record '{$record->vaccine_name}' for pet '{$record->pet->name}'", $record);

        return redirect()->route('vaccination-records.index')->with('success', 'Vaccination record added successfully.');
    }

    public function edit(VaccinationRecord $vaccinationRecord)
    {
        if (auth()->user()->role === 'owner') {
            abort(403);
        }

        $pets = \App\Models\Pet::all();

        return view('vaccination-records.edit', compact('vaccinationRecord', 'pets'));
    }

    public function update(Request $request, VaccinationRecord $vaccinationRecord)
    {
        if (auth()->user()->role === 'owner') {
            abort(403);
        }

        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'vaccine_name' => 'required|string|max:255',
            'administered_date' => 'required|date',
            'due_date' => 'nullable|date',
            'status' => 'required|in:given,pending',
        ]);

        $vaccinationRecord->update($validated);
        ActivityLog::log('Updated Vaccination', "Updated vaccination record '{$vaccinationRecord->vaccine_name}' for pet '{$vaccinationRecord->pet->name}'", $vaccinationRecord);

        return redirect()->route('vaccination-records.index')->with('success', 'Vaccination record updated successfully.');
    }

    public function destroy(VaccinationRecord $vaccinationRecord)
    {
        if (auth()->user()->role === 'owner') {
            abort(403);
        }

        ActivityLog::log('Deleted Vaccination', "Deleted vaccination record ID {$vaccinationRecord->id}");
        $vaccinationRecord->delete();
        return back()->with('success', 'Vaccination record deleted successfully.');
    }
}
