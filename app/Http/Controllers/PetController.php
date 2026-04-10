<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pet::with('owner');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('species', 'like', "%{$search}%")
                  ->orWhereHas('owner', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $pets = $query->paginate(10);
        return view('pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $owners = \App\Models\User::where('role', 'owner')->get();
        return view('pets.create', compact('owners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'weight' => 'nullable|numeric',
            'medical_history' => 'nullable|string',
        ]);

        $pet = Pet::create($validated);
        ActivityLog::log('Created Pet', "Created pet record for {$pet->name}", $pet);

        return redirect()->route('pets.index')->with('success', 'Pet record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        $pet->load(['owner', 'medicalRecords.vet', 'vaccinationRecords']);
        return view('pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        $owners = \App\Models\User::where('role', 'owner')->get();
        return view('pets.edit', compact('pet', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'weight' => 'nullable|numeric',
            'medical_history' => 'nullable|string',
        ]);

        $pet->update($validated);
        ActivityLog::log('Updated Pet', "Updated pet record for {$pet->name}", $pet);

        return redirect()->route('pets.index')->with('success', 'Pet record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        ActivityLog::log('Deleted Pet', "Deleted pet record for {$pet->name}");
        $pet->delete();
        return redirect()->route('pets.index')->with('success', 'Pet record deleted successfully.');
    }
}
