@extends('layouts.valex')
@section('page-title', 'Edit Vaccination')
@section('breadcrumb-parent', 'Vaccinations')
@section('breadcrumb-child', 'Edit')

@section('content')
    <div class="xl:col-span-12 col-span-12">
        <div class="box custom-box mt-3">
            <div class="box-header">
                <div class="box-title">
                    Edit Vaccination Record
                </div>
            </div>
            <form action="{{ panel_route('vaccination-records.update', $vaccinationRecord->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="box-body">
                    <div class="grid grid-cols-12 gap-x-6 gap-y-4">
                        {{-- Pet Selection --}}
                        <div class="xl:col-span-6 col-span-12">
                            <label for="pet_id" class="form-label">Pet</label>
                            <select name="pet_id" id="pet_id" class="form-control" required>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}" {{ $pet->id == $vaccinationRecord->pet_id ? 'selected' : '' }}>{{ $pet->name }} (Owner: {{ $pet->owner->name }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Vaccine Name --}}
                        <div class="xl:col-span-6 col-span-12">
                            <label for="vaccine_name" class="form-label">Vaccine Name</label>
                            <input type="text" name="vaccine_name" id="vaccine_name" class="form-control" value="{{ $vaccinationRecord->vaccine_name }}" required>
                        </div>

                        {{-- Date Given --}}
                        <div class="xl:col-span-4 col-span-12">
                            <label for="administered_date" class="form-label">Date Given</label>
                            <input type="date" name="administered_date" id="administered_date" class="form-control" value="{{ $vaccinationRecord->administered_date }}" required>
                        </div>

                        {{-- Due Date --}}
                        <div class="xl:col-span-4 col-span-12">
                            <label for="due_date" class="form-label">Next Dose Due (Optional)</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $vaccinationRecord->due_date }}">
                        </div>

                        {{-- Status --}}
                        <div class="xl:col-span-4 col-span-12">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="given" {{ $vaccinationRecord->status === 'given' ? 'selected' : '' }}>Given</option>
                                <option value="pending" {{ $vaccinationRecord->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="ti-btn ti-btn-primary-full ti-btn-wave">Update Record</button>
                    <a href="{{ panel_route('vaccination-records.index') }}" class="ti-btn ti-btn-secondary-full ti-btn-wave">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
