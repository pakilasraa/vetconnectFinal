@extends('layouts.valex')
@section('page-title', 'Edit Appointment')
@section('breadcrumb-parent', 'Appointment Management')
@section('breadcrumb-child', 'Edit')

@section('content')
    <div class="xl:col-span-12 col-span-12">

        <div class="box custom-box mt-3">
            <div class="box-header">
                <div class="box-title">Appointment Details</div>
            </div>
            <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="box-body">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="xl:col-span-6 col-span-12">
                            <label for="user_id" class="form-label">Pet Owner</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ $appointment->user_id == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="pet_id" class="form-label">Pet</label>
                            <select name="pet_id" id="pet_id" class="form-control" required>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}" {{ $appointment->pet_id == $pet->id ? 'selected' : '' }}>{{ $pet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="appointment_date" class="form-label">Appointment Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required value="{{ $appointment->appointment_date }}">
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="appointment_time" class="form-label">Appointment Time</label>
                            <input type="time" name="appointment_time" id="appointment_time" class="form-control" required value="{{ $appointment->appointment_time }}">
                            @error('appointment_time')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="service_type" class="form-label">Service Type</label>
                            <select name="service_type" id="service_type" class="form-control" required>
                                <option value="Consultation" {{ $appointment->service_type == 'Consultation' ? 'selected' : '' }}>Consultation</option>
                                <option value="Vaccination" {{ $appointment->service_type == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                                <option value="Surgery" {{ $appointment->service_type == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                                <option value="Grooming" {{ $appointment->service_type == 'Grooming' ? 'selected' : '' }}>Grooming</option>
                                <option value="Check-up" {{ $appointment->service_type == 'Check-up' ? 'selected' : '' }}>Check-up</option>
                            </select>
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="xl:col-span-12 col-span-12">
                            <label for="notes" class="form-label">Additional Notes (Optional)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ $appointment->notes }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-end">
                    <a href="{{ route('appointments.index') }}" class="ti-btn ti-btn-light">Cancel</a>
                    <button type="submit" class="ti-btn ti-btn-primary">Update Appointment</button>
                </div>
            </form>
        </div>
    </div>
@endsection
