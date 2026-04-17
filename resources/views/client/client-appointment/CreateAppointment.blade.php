@extends('layouts.clientapp')

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
        </div>

        <div class="form-group">
            <label for="type" class="form-label">Appointment Type *</label>
            <select id="type" name="type" class="form-input" required>
                <option value="">Select type</option>
                <option value="General Checkup" {{ old('type') == 'General Checkup' ? 'selected' : '' }}>General Checkup</option>
                <option value="Vaccination" {{ old('type') == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                <option value="Dental Cleaning" {{ old('type') == 'Dental Cleaning' ? 'selected' : '' }}>Dental Cleaning</option>
                <option value="Surgery" {{ old('type') == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                <option value="Emergency" {{ old('type') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                <option value="Follow-up" {{ old('type') == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
            </select>
        </div>

        <div class="form-group">
            <label for="appointment_date" class="form-label">Date *</label>
            <input type="date" id="appointment_date" name="appointment_date"
                   value="{{ old('appointment_date') }}"
                   min="{{ date('Y-m-d') }}"
                   class="form-input" required>
        </div>

        <div class="form-group">
            <label for="appointment_time" class="form-label">Time *</label>
            <select id="appointment_time" name="appointment_time" class="form-input" required>
                <option value="">Select time</option>
                <option value="9:00 AM" {{ old('appointment_time') == '9:00 AM' ? 'selected' : '' }}>9:00 AM</option>
                <option value="10:00 AM" {{ old('appointment_time') == '10:00 AM' ? 'selected' : '' }}>10:00 AM</option>
                <option value="11:00 AM" {{ old('appointment_time') == '11:00 AM' ? 'selected' : '' }}>11:00 AM</option>
                <option value="2:00 PM" {{ old('appointment_time') == '2:00 PM' ? 'selected' : '' }}>2:00 PM</option>
                <option value="3:00 PM" {{ old('appointment_time') == '3:00 PM' ? 'selected' : '' }}>3:00 PM</option>
                <option value="4:00 PM" {{ old('appointment_time') == '4:00 PM' ? 'selected' : '' }}>4:00 PM</option>
            </select>
        </div>

        <div class="form-group">
            <label for="doctor" class="form-label">Preferred Doctor</label>
            <select id="doctor" name="doctor" class="form-input">
                <option value="">Any available</option>
                <option value="Dr. Sarah Johnson" {{ old('doctor') == 'Dr. Sarah Johnson' ? 'selected' : '' }}>Dr. Sarah Johnson</option>
                <option value="Dr. Michael Chen" {{ old('doctor') == 'Dr. Michael Chen' ? 'selected' : '' }}>Dr. Michael Chen</option>
                <option value="Dr. Emily Rodriguez" {{ old('doctor') == 'Dr. Emily Rodriguez' ? 'selected' : '' }}>Dr. Emily Rodriguez</option>
            </select>
        </div>

        <div class="form-group">
            <label for="notes" class="form-label">Notes</label>
            <textarea id="notes" name="notes" rows="3" class="form-input" placeholder="Any additional information for the vet...">{{ old('notes') }}</textarea>
        </div>

        <div class="form-actions">
            <a href="{{ panel_route('appointments.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </div>
    </form>
</div>
@endsection
