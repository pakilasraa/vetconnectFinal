@extends('layouts.valex')
@section('page-title', 'Add medicine')

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

        .medicine-helper-list {
            margin: 0;
            padding-left: 1rem;
            color: rgb(var(--text-muted));
            font-size: 0.8rem;
            line-height: 1.5;
        }

        .medicine-tips-chip {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 0.2rem 0.55rem;
            font-size: 0.7rem;
            font-weight: 700;
            background: rgb(var(--primary-rgb) / 0.12);
            color: rgb(var(--primary-rgb));
            margin-right: 0.35rem;
            margin-bottom: 0.35rem;
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
                <div class="box-title">New inventory item</div>
                <a href="{{ route('admin.medicines.index') }}" class="ti-btn ti-btn-light ti-btn-wave !py-1 !px-2 !text-[0.75rem]">Back to Inventory</a>
            </div>
            <form action="{{ route('admin.medicines.store') }}" method="POST">
                @csrf
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
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required maxlength="255">
                                </div>
                                <div class="xl:col-span-6 col-span-12">
                                    <label for="sku" class="form-label">SKU / code (optional)</label>
                                    <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku') }}" maxlength="100">
                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="quantity" class="form-label">Quantity in stock</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', 0) }}" min="0" required>
                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input type="text" name="unit" id="unit" class="form-control" value="{{ old('unit', 'pc') }}" required maxlength="32" placeholder="pc, bottle, box...">
                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="reorder_level" class="form-label">Reorder level</label>
                                    <input type="number" name="reorder_level" id="reorder_level" class="form-control" value="{{ old('reorder_level', 5) }}" min="0" required>
                                </div>
                                <div class="xl:col-span-6 col-span-12">
                                    <label for="expiry_date" class="form-label">Expiry date (optional)</label>
                                    <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                                </div>
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Batch, supplier, storage...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <aside class="medicine-panel">
                            <div class="medicine-panel-title">Inventory guide</div>
                            <div class="mb-3">
                                <span class="medicine-tips-chip">Track by SKU</span>
                                <span class="medicine-tips-chip">Set reorder threshold</span>
                                <span class="medicine-tips-chip">Record expiry</span>
                            </div>
                            <ul class="medicine-helper-list">
                                <li>Use a consistent unit format (for example: pc, bottle, box).</li>
                                <li>Set reorder level to your minimum safe stock per item.</li>
                                <li>Leave expiry date empty only for non-expiring inventory.</li>
                                <li>Add batch or supplier details in Notes for traceability.</li>
                            </ul>
                        </aside>
                    </div>
                </div>
                <div class="box-footer flex items-center gap-2">
                    <button type="submit" class="ti-btn ti-btn-primary-full ti-btn-wave">Save Item</button>
                    <a href="{{ route('admin.medicines.index') }}" class="ti-btn ti-btn-secondary-full ti-btn-wave">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
