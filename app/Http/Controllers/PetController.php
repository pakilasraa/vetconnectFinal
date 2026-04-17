<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RedirectsToPanelRoute;
use App\Models\ActivityLog;
use App\Models\Pet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetController extends Controller
{
    use RedirectsToPanelRoute;

    public function index(Request $request): View
    {
        $query = Pet::with('owner');

        if ($request->user()->isPetOwner()) {
            $query->where('owner_id', $request->user()->id);
        }

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('species', 'like', "%{$search}%")
                    ->orWhereHas('owner', function ($oq) use ($search) {
                        $oq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->routeIs('client.pets.*')) {
            $pets = $query->latest()->get();

            return view('client.my-pets.MyPets', compact('pets'));
        }

        $pets = $query->paginate(10);

        return view('pets.index', compact('pets'));
    }

    public function create(Request $request): View
    {
        if ($request->user()->isPetOwner()) {
            return view('pets.create', ['owners' => collect()]);
        }

        $owners = \App\Models\User::where('role', 'pet_owner')->get();

        return view('pets.create', compact('owners'));
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'weight' => 'nullable|numeric',
            'medical_history' => 'nullable|string',
        ];

        if ($request->user()->isAdmin()) {
            $rules['owner_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        $validated['owner_id'] = $request->user()->isPetOwner()
            ? $request->user()->id
            : $validated['owner_id'];

        $pet = Pet::create($validated);
        ActivityLog::log('Created Pet', "Created pet record for {$pet->name}", $pet);

        return $this->panelRedirect('pets.index')->with('success', 'Pet record created successfully.');
    }

    public function show(Request $request, Pet $pet): View|RedirectResponse
    {
        if ($redirect = $this->ensurePetAccessible($request, $pet)) {
            return $redirect;
        }

        $pet->load(['owner', 'medicalRecords.vet', 'vaccinationRecords', 'appointments']);

        if ($request->routeIs('client.pets.*')) {
            return view('client.pets.show', compact('pet'));
        }

        return view('pets.show', compact('pet'));
    }

    public function edit(Request $request, Pet $pet): View|RedirectResponse
    {
        if ($redirect = $this->ensurePetAccessible($request, $pet)) {
            return $redirect;
        }

        if ($request->user()->isPetOwner()) {
            return view('pets.edit', ['pet' => $pet, 'owners' => collect()]);
        }

        $owners = \App\Models\User::where('role', 'pet_owner')->get();

        return view('pets.edit', compact('pet', 'owners'));
    }

    public function update(Request $request, Pet $pet): RedirectResponse
    {
        if ($redirect = $this->ensurePetAccessible($request, $pet)) {
            return $redirect;
        }

        $rules = [
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'weight' => 'nullable|numeric',
            'medical_history' => 'nullable|string',
        ];

        if ($request->user()->isAdmin()) {
            $rules['owner_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        $validated['owner_id'] = $request->user()->isPetOwner()
            ? $pet->owner_id
            : $validated['owner_id'];

        $pet->update($validated);
        ActivityLog::log('Updated Pet', "Updated pet record for {$pet->name}", $pet);

        return $this->panelRedirect('pets.index')->with('success', 'Pet record updated successfully.');
    }

    public function destroy(Request $request, Pet $pet): RedirectResponse
    {
        if ($redirect = $this->ensurePetAccessible($request, $pet)) {
            return $redirect;
        }

        ActivityLog::log('Deleted Pet', "Deleted pet record for {$pet->name}");
        $pet->delete();

        return $this->panelRedirect('pets.index')->with('success', 'Pet record deleted successfully.');
    }

    private function ensurePetAccessible(Request $request, Pet $pet): ?RedirectResponse
    {
        if ($request->user()->isPetOwner() && $pet->owner_id !== $request->user()->id) {
            return redirect()->route('not-authorized');
        }

        return null;
    }
}
