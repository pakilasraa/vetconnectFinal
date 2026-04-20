@extends('layouts.client-app')

@section('title', 'Book Appointment - VetConnect')

@section('content')
<div class="page-header">
    <h1 class="page-title">Book Appointment</h1>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ panel_route('appointments.store') }}" method="POST" class="form">
        @csrf

        <div class="form-group">
            <label for="pet_id" class="form-label">Select Pet *</label>
            <select id="pet_id" name="pet_id" class="form-input" required>
                <option value="">Choose a pet</option>
                @foreach($pets as $pet)
                    <option value="{{ $pet->id }}" {{ old('pet_id') == $pet->id ? 'selected' : '' }}>
                        {{ $pet->name }}
                    </option>
                @endforeach
            </select>
            @error('pet_id') <p class="text-error mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="service_type" class="form-label">Service Type *</label>
            <select id="service_type" name="service_type" class="form-input" required>
                <option value="">Select type</option>
                <option value="Consultation" {{ old('service_type') == 'Consultation' ? 'selected' : '' }}>Consultation</option>
                <option value="Vaccination" {{ old('service_type') == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                <option value="Check-up" {{ old('service_type') == 'Check-up' ? 'selected' : '' }}>Check-up</option>
                <option value="Surgery" {{ old('service_type') == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                <option value="Grooming" {{ old('service_type') == 'Grooming' ? 'selected' : '' }}>Grooming</option>
            </select>
            @error('service_type') <p class="text-error mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="appointment_date" class="form-label">Date *</label>
                <input type="date" id="appointment_date" name="appointment_date"
                       value="{{ old('appointment_date') }}"
                       min="{{ date('Y-m-d') }}"
                       class="form-input" required>
                @error('appointment_date') <p class="text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="appointment_time" class="form-label">Time *</label>
                <select id="appointment_time" name="appointment_time" class="form-input" required>
                    <option value="">Select time</option>
                    @foreach(\App\Support\AppointmentSlots::times() as $time)
                        @php 
                            $time_obj = \Carbon\Carbon::createFromFormat('H:i:s', $time);
                            $formatted_time = $time_obj->format('g:i A');
                        @endphp
                        <option value="{{ $time }}" {{ old('appointment_time') == $time ? 'selected' : '' }}>
                            {{ $formatted_time }}
                        </option>
                    @endforeach
                </select>
                @error('appointment_time') <p class="text-error mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="notes" class="form-label">Notes</label>
            <textarea id="notes" name="notes" rows="3" class="form-input" placeholder="Any additional information for the vet...">{{ old('notes') }}</textarea>
            @error('notes') <p class="text-error mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="form-actions">
            <a href="{{ panel_route('appointments.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </div>
    </form>
</div>
@endsection
