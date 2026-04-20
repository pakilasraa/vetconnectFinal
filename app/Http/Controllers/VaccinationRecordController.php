<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RedirectsToPanelRoute;
use App\Models\ActivityLog;
use App\Models\VaccinationRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VaccinationRecordController extends Controller
{
    use RedirectsToPanelRoute;

    public function index(Request $request): View
    {
        $user = auth()->user();
        if ($user->isPetOwner()) {
            $records = VaccinationRecord::whereHas('pet', function ($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->with('pet')->orderBy('administered_date', 'desc')->get();
        } else {
            $records = VaccinationRecord::with('pet')->orderBy('administered_date', 'desc')->get();
        }

        if ($request->routeIs('client.*')) {
            return view('client.vaccination-records.index', compact('records'));
        }

        return view('vaccination-records.index', compact('records'));
    }

    public function create(): View
    {
        if (auth()->user()->isPetOwner()) {
            abort(403);
        }

        $pets = \App\Models\Pet::all();

        return view('vaccination-records.create', compact('pets'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->isPetOwner()) {
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

        return $this->panelRedirect('vaccination-records.index')->with('success', 'Vaccination record added successfully.');
    }

    public function edit(VaccinationRecord $vaccinationRecord): View
    {
        if (auth()->user()->isPetOwner()) {
            abort(403);
        }

        $pets = \App\Models\Pet::all();

        return view('vaccination-records.edit', compact('vaccinationRecord', 'pets'));
    }

    public function update(Request $request, VaccinationRecord $vaccinationRecord): RedirectResponse
    {
        if (auth()->user()->isPetOwner()) {
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

        return $this->panelRedirect('vaccination-records.index')->with('success', 'Vaccination record updated successfully.');
    }

    public function destroy(VaccinationRecord $vaccinationRecord): RedirectResponse
    {
        if (auth()->user()->isPetOwner()) {
            abort(403);
        }

        ActivityLog::log('Deleted Vaccination', "Deleted vaccination record ID {$vaccinationRecord->id}");
        $vaccinationRecord->delete();

        return back()->with('success', 'Vaccination record deleted successfully.');
    }
}
