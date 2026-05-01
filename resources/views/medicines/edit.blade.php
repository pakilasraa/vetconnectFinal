@extends('layouts.valex')
@section('page-title', 'Edit medicine')

@section('styles')
    <style>
        .medicine-form-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 1rem;
        }

        .medicine-panel {
            border: 1px solid rgb(var(--light-rgb) / 0.8);
            border-radius: 0.75rem;
            padding: 1rem;
            background: var(--custom-white);
        }

        .medicine-panel-title {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgb(var(--text-muted));
            margin-bottom: 0.8rem;
            font-weight: 700;
        }

        .medicine-meta-row {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.55rem 0;
            border-bottom: 1px dashed rgb(var(--light-rgb) / 0.8);
            font-size: 0.82rem;
        }

        .medicine-meta-row:last-child {
            border-bottom: none;
        }

        @media (max-width: 1100px) {
            .medicine-form-grid { grid-template-columns: 1fr; }
        }
    </style>
@endsection

@section('content')
    <div class="xl:col-span-12 col-span-12">
        <div class="box custom-box mt-3">
            <div class="box-header flex justify-between">
                <div class="box-title">Update inventory item</div>
                <a href="{{ route('admin.medicines.index') }}" class="ti-btn ti-btn-light ti-btn-wave !py-1 !px-2 !text-[0.75rem]">Back to Inventory</a>
            </div>
            <form action="{{ route('admin.medicines.update', $medicine) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="box-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4" role="alert">
                            <ul class="mb-0 ps-4 list-disc">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="medicine-form-grid">
                        <div class="medicine-panel">
                            <div class="medicine-panel-title">Medicine details</div>
                            <div class="grid grid-cols-12 gap-x-6 gap-y-4">
                                <div class="xl:col-span-6 col-span-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $medicine->name) }}" required maxlength="255">
                                </div>
                                <div class="xl:col-span-6 col-span-12">
                                    <label for="sku" class="form-label">SKU / code (optional)</label>
                                    <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku', $medicine->sku) }}" maxlength="100">
                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="quantity" class="form-label">Quantity in stock</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $medicine->quantity) }}" min="0" required>
                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input type="text" name="unit" id="unit" class="form-control" value="{{ old('unit', $medicine->unit) }}" required maxlength="32">
                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="reorder_level" class="form-label">Reorder level</label>
                                    <input type="number" name="reorder_level" id="reorder_level" class="form-control" value="{{ old('reorder_level', $medicine->reorder_level) }}" min="0" required>
                                </div>
                                <div class="xl:col-span-6 col-span-12">
                                    <label for="expiry_date" class="form-label">Expiry date (optional)</label>
                                    <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date', $medicine->expiry_date?->format('Y-m-d')) }}">
                                </div>
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $medicine->notes) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <aside class="medicine-panel">
                            <div class="medicine-panel-title">Current snapshot</div>
                            <div class="medicine-meta-row">
                                <span class="text-textmuted">Current stock</span>
                                <strong>{{ number_format($medicine->quantity) }} {{ $medicine->unit }}</strong>
                            </div>
                            <div class="medicine-meta-row">
                                <span class="text-textmuted">Reorder level</span>
                                <strong>{{ number_format($medicine->reorder_level) }}</strong>
                            </div>
                            <div class="medicine-meta-row">
                                <span class="text-textmuted">Expiry date</span>
                                <strong>{{ $medicine->expiry_date ? $medicine->expiry_date->format('M j, Y') : 'Not set' }}</strong>
                            </div>
                            <div class="medicine-meta-row">
                                <span class="text-textmuted">Availability</span>
                                @php $state = $medicine->availabilityState(); @endphp
                                <span class="badge {{ $state['class'] }}">{{ $state['label'] }}</span>
                            </div>
                        </aside>
                    </div>
                </div>
                <div class="box-footer flex items-center gap-2">
                    <button type="submit" class="ti-btn ti-btn-primary-full ti-btn-wave">Save Changes</button>
                    <a href="{{ route('admin.medicines.index') }}" class="ti-btn ti-btn-secondary-full ti-btn-wave">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
