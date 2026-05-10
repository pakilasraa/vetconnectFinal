@extends('layouts.client-app')

@section('title', 'Reschedule Appointment - VetConnect')

@section('content')
<div class="page-header">
    <h1 class="page-title">Reschedule Appointment</h1>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ panel_route('appointments.update', $appointment) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Reference #</label>
            <input type="text" class="form-input" value="{{ $appointment->reference_number ?: ('#'.$appointment->id) }}" readonly>
        </div>

        <div class="form-group">
            <label for="pet_id" class="form-label">Pet</label>
            <input type="text" class="form-input" value="{{ $appointment->pet->name }}" readonly style="background-color: #f8fafc;">
            <input type="hidden" name="pet_id" value="{{ $appointment->pet_id }}">
            <input type="hidden" name="user_id" value="{{ $appointment->user_id }}">
        </div>

        <div class="form-group">
            <label for="service_type" class="form-label">Service Type *</label>
            <select id="service_type" name="service_type" class="form-input" required>
                <option value="Consultation" {{ old('service_type', $appointment->service_type) == 'Consultation' ? 'selected' : '' }}>Consultation</option>
                <option value="Vaccination" {{ old('service_type', $appointment->service_type) == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                <option value="Check-up" {{ old('service_type', $appointment->service_type) == 'Check-up' ? 'selected' : '' }}>Check-up</option>
                <option value="Surgery" {{ old('service_type', $appointment->service_type) == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                <option value="Grooming" {{ old('service_type', $appointment->service_type) == 'Grooming' ? 'selected' : '' }}>Grooming</option>
            </select>
            @error('service_type') <p class="text-error mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="appointment_date" class="form-label">Date *</label>
                <input type="date" id="appointment_date" name="appointment_date"
                       value="{{ old('appointment_date', $appointment->appointment_date) }}"
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
                        <option value="{{ $time }}" {{ old('appointment_time', $appointment->appointment_time) == $time ? 'selected' : '' }}>
                            {{ $formatted_time }}
                        </option>
                    @endforeach
                </select>
                <p id="appointment_time_hint" class="text-muted mt-1 mb-0" style="font-size: 12px;"></p>
                @error('appointment_time') <p class="text-error mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="notes" class="form-label">Notes</label>
            <textarea id="notes" name="notes" rows="3" class="form-input" placeholder="Any additional information for the vet...">{{ old('notes', $appointment->notes) }}</textarea>
            @error('notes') <p class="text-error mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="form-actions">
            <a href="{{ panel_route('appointments.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Appointment</button>
        </div>
    </form>
</div>

<script>
    (function () {
        const dateInput = document.getElementById('appointment_date');
        const timeSelect = document.getElementById('appointment_time');
        const hint = document.getElementById('appointment_time_hint');
        if (!dateInput || !timeSelect) return;

        const options = Array.from(timeSelect.options).filter((option) => option.value !== '');

        function updateTimeHint(bookedCount) {
            if (!hint) return;
            if (!dateInput.value) {
                hint.textContent = 'Select a date to see which time slots are already taken.';
                return;
            }
            hint.textContent = bookedCount > 0
                ? `${bookedCount} slot(s) already taken for this day.`
                : 'All time slots are currently open for this day.';
        }

        async function refreshBookedSlots() {
            const selectedDate = dateInput.value;
            options.forEach((option) => {
                option.disabled = false;
                option.textContent = option.textContent.replace(' (Taken)', '');
            });

            if (!selectedDate) {
                updateTimeHint(0);
                return;
            }

            try {
                const response = await fetch(`{{ route('client.appointments.booked-slots') }}?date=${encodeURIComponent(selectedDate)}&exclude_id={{ $appointment->id }}`);
                if (!response.ok) {
                    updateTimeHint(0);
                    return;
                }

                const data = await response.json();
                const booked = new Set((data.booked || []).map(String));
                let bookedCount = 0;

                options.forEach((option) => {
                    if (booked.has(option.value)) {
                        bookedCount++;
                        option.disabled = true;
                        if (!option.textContent.includes(' (Taken)')) {
                            option.textContent = `${option.textContent} (Taken)`;
                        }
                    }
                });

                if (timeSelect.value && timeSelect.selectedOptions[0]?.disabled) {
                    timeSelect.value = '';
                }

                updateTimeHint(bookedCount);
            } catch (error) {
                updateTimeHint(0);
            }
        }

        dateInput.addEventListener('change', refreshBookedSlots);
        refreshBookedSlots();
    })();
</script>
@endsection
