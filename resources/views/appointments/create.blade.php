@extends('layouts.valex')
@section('page-title', 'Book Appointment')
@section('breadcrumb-parent', 'Appointment Management')
@section('breadcrumb-child', 'Book')

@section('content')
    <div class="xl:col-span-12 col-span-12">

        <div class="box custom-box mt-3">
            <div class="box-header">
                <div class="box-title">Appointment Details</div>
            </div>
            <form action="{{ panel_route('appointments.store') }}" method="POST">
                @csrf
                <div class="box-body">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="xl:col-span-6 col-span-12">
                            <label for="user_id" class="form-label">Pet Owner</label>
                            @if(auth()->user()->isPetOwner())
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            @else
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">Select Owner</option>
                                    @foreach($owners as $owner)
                                        <option value="{{ $owner->id }}" {{ old('user_id') == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="pet_id" class="form-label">Pet</label>
                            <select name="pet_id" id="pet_id" class="form-control" required>
                                <option value="">Select Pet</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}" {{ old('pet_id') == $pet->id ? 'selected' : '' }}>{{ $pet->name }} ({{ $pet->species }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="appointment_date" class="form-label">Appointment Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required value="{{ old('appointment_date') }}">
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="appointment_time" class="form-label">Appointment Time</label>
                            <input type="time" name="appointment_time" id="appointment_time" class="form-control" required value="{{ old('appointment_time') }}">
                            @error('appointment_time')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="service_type" class="form-label">Service Type</label>
                            <select name="service_type" id="service_type" class="form-control" required>
                                <option value="">Select Service</option>
                                <option value="Consultation" {{ old('service_type') == 'Consultation' ? 'selected' : '' }}>Consultation</option>
                                <option value="Vaccination" {{ old('service_type') == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                                <option value="Surgery" {{ old('service_type') == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                                <option value="Grooming" {{ old('service_type') == 'Grooming' ? 'selected' : '' }}>Grooming</option>
                                <option value="Check-up" {{ old('service_type') == 'Check-up' ? 'selected' : '' }}>Check-up</option>
                            </select>
                        </div>
                        <div class="xl:col-span-12 col-span-12">
                            <label for="notes" class="form-label">Additional Notes (Optional)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-end">
                    <a href="{{ panel_route('appointments.index') }}" class="ti-btn ti-btn-light">Cancel</a>
                    <button type="submit" class="ti-btn ti-btn-primary">Book Appointment</button>
                </div>
            </form>
        </div>
    </div>
@endsection
