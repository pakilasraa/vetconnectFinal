<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Medicine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicineController extends Controller
{
    public function index(): View
    {
        $medicines = Medicine::orderBy('name')->get();

        return view('medicines.index', compact('medicines'));
    }

    public function create(): View
    {
        return view('medicines.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:32',
            'expiry_date' => 'nullable|date',
            'reorder_level' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $medicine = Medicine::create($validated);
        ActivityLog::log('Added medicine', "Added medicine '{$medicine->name}' to inventory", $medicine);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine saved.');
    }

    public function edit(Medicine $medicine): View
    {
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:32',
            'expiry_date' => 'nullable|date',
            'reorder_level' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $medicine->update($validated);
        ActivityLog::log('Updated medicine', "Updated medicine '{$medicine->name}'", $medicine);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated.');
    }

    public function destroy(Medicine $medicine): RedirectResponse
    {
        ActivityLog::log('Deleted medicine', "Removed medicine '{$medicine->name}' from inventory");
        $medicine->delete();

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine removed.');
    }
}
