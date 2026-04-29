@extends('layouts.valex')
@section('page-title', 'New Consultation')

@section('content')
    <div class="xl:col-span-12 col-span-12">
        <div class="box custom-box mt-3">
            <div class="box-header">
                <div class="box-title">
                    Record New Consultation
                </div>
            </div>
            <form action="{{ panel_route('medical-records.store') }}" method="POST">
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
                        {{-- Pet Selection --}}
                        <div class="xl:col-span-6 col-span-12">
                            <label for="pet_id" class="form-label">Pet</label>
                            <select name="pet_id" id="pet_id" class="form-control" required>
                                <option value="" disabled {{ old('pet_id') ? '' : 'selected' }}>Select Pet</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}" {{ (string) old('pet_id') === (string) $pet->id ? 'selected' : '' }}>{{ $pet->name }} (Owner: {{ $pet->owner->name }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Vet Selection --}}
                        <div class="xl:col-span-6 col-span-12">
                            <label for="vet_id" class="form-label">Veterinarian</label>
                            <select name="vet_id" id="vet_id" class="form-control" required>
                                @foreach($vets as $vet)
                                    <option value="{{ $vet->id }}" {{ (string) old('vet_id', (string) auth()->id()) === (string) $vet->id ? 'selected' : '' }}>{{ $vet->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Date --}}
                        <div class="xl:col-span-6 col-span-12">
                            <label for="visit_date" class="form-label">Visit Date</label>
                            <input type="date" name="visit_date" id="visit_date" class="form-control" value="{{ old('visit_date', date('Y-m-d')) }}" required>
                        </div>

                        {{-- Diagnosis --}}
                        <div class="xl:col-span-12 col-span-12">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" required placeholder="Describe the pet's condition...">{{ old('diagnosis') }}</textarea>
                        </div>

                        {{-- Treatment --}}
                        <div class="xl:col-span-12 col-span-12">
                            <label for="treatment" class="form-label">Treatment</label>
                            <textarea name="treatment" id="treatment" class="form-control" rows="3" placeholder="Describe the treatment provided...">{{ old('treatment') }}</textarea>
                        </div>

                        {{-- Prescription --}}
                        <div class="xl:col-span-12 col-span-12">
                            <label for="prescription" class="form-label">Prescription</label>
                            <textarea name="prescription" id="prescription" class="form-control" rows="3" placeholder="Enter medication reseta...">{{ old('prescription') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="ti-btn ti-btn-primary-full ti-btn-wave">Save Record</button>
                    <a href="{{ panel_route('medical-records.index') }}" class="ti-btn ti-btn-secondary-full ti-btn-wave">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
