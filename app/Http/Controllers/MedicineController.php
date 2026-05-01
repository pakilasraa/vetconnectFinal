<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Medicine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicineController extends Controller
{
    public function index(Request $request): View
    {
        $today = now()->startOfDay();
        $search = trim((string) $request->get('search', ''));
        $status = (string) $request->get('status', 'all');

        $query = Medicine::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($status === 'expired') {
            $query->whereDate('expiry_date', '<', $today->toDateString());
        } elseif ($status === 'out') {
            $query->where('quantity', '<=', 0)
                ->where(function ($q) use ($today) {
                    $q->whereNull('expiry_date')
                        ->orWhereDate('expiry_date', '>=', $today->toDateString());
                });
        } elseif ($status === 'low') {
            $query->where('quantity', '>', 0)
                ->whereColumn('quantity', '<=', 'reorder_level')
                ->where(function ($q) use ($today) {
                    $q->whereNull('expiry_date')
                        ->orWhereDate('expiry_date', '>=', $today->toDateString());
                });
        } elseif ($status === 'ok') {
            $query->whereColumn('quantity', '>', 'reorder_level')
                ->where(function ($q) use ($today) {
                    $q->whereNull('expiry_date')
                        ->orWhereDate('expiry_date', '>=', $today->toDateString());
                });
        }

        $medicines = $query->orderBy('name')->get();

        $allMedicines = Medicine::all();
        $inventorySummary = [
            'total_items' => $allMedicines->count(),
            'total_units' => $allMedicines->sum('quantity'),
            'ok' => 0,
            'low' => 0,
            'out' => 0,
            'expired' => 0,
        ];

        foreach ($allMedicines as $medicine) {
            $state = $medicine->availabilityState();
            $inventorySummary[$state['key']] = ($inventorySummary[$state['key']] ?? 0) + 1;
        }

        return view('medicines.index', compact(
            'medicines',
            'inventorySummary',
            'search',
            'status'
        ));
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
