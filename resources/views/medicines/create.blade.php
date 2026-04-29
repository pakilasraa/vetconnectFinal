@extends('layouts.valex')
@section('page-title', 'Add medicine')

@section('content')
    <div class="xl:col-span-12 col-span-12">
        <div class="box custom-box mt-3">
            <div class="box-header">
                <div class="box-title">New inventory item</div>
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
                            <input type="text" name="unit" id="unit" class="form-control" value="{{ old('unit', 'pc') }}" required maxlength="32" placeholder="pc, bottle, box…">
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
                            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Batch, supplier, storage…">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="ti-btn ti-btn-primary-full ti-btn-wave">Save</button>
                    <a href="{{ route('admin.medicines.index') }}" class="ti-btn ti-btn-secondary-full ti-btn-wave">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
