<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RedirectsToPanelRoute;
use App\Models\ActivityLog;
use App\Models\MedicalRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicalRecordController extends Controller
{
    use RedirectsToPanelRoute;

    public function index(Request $request): View
    {
        $user = auth()->user();
        if ($user->isPetOwner()) {
            return redirect()->to(route('client.pets.index').'#medical-records');
        }

        $records = MedicalRecord::with(['pet', 'vet'])->orderBy('visit_date', 'desc')->get();

        return view('medical-records.index', compact('records'));
    }

    public function create(): View
    {
        if (auth()->user()->isPetOwner()) {
            abort(403);
        }

        $pets = \App\Models\Pet::with('owner')->orderBy('name')->get();
        $vets = \App\Models\User::where('role', 'admin')->orderBy('name')->get();

        return view('medical-records.create', compact('pets', 'vets'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->isPetOwner()) {
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

        return $this->panelRedirect('medical-records.index')->with('success', 'Medical record added successfully.');
    }

    public function edit(MedicalRecord $medicalRecord): View
    {
        if (auth()->user()->isPetOwner()) {
            abort(403);
        }

        $pets = \App\Models\Pet::with('owner')->orderBy('name')->get();
        $vets = \App\Models\User::where('role', 'admin')->orderBy('name')->get();

        return view('medical-records.edit', compact('medicalRecord', 'pets', 'vets'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord): RedirectResponse
    {
        if (auth()->user()->isPetOwner()) {
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

        return $this->panelRedirect('medical-records.index')->with('success', 'Medical record updated successfully.');
    }

    public function destroy(MedicalRecord $medicalRecord): RedirectResponse
    {
        if (auth()->user()->isPetOwner()) {
            abort(403);
        }

        ActivityLog::log('Deleted Medical Record', "Deleted medical record ID {$medicalRecord->id}");
        $medicalRecord->delete();

        return back()->with('success', 'Medical record deleted successfully.');
    }
}
