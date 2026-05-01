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
            <div id="selected_date_display" class="selected-date-banner is-empty">
                <div class="selected-date-icon" aria-hidden="true">&#128197;</div>
                <div class="selected-date-content">
                    <p class="selected-date-label">Selected date</p>
                    <p class="selected-date-value">Please choose a date.</p>
                </div>
            </div>
        </div>

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
                       value="{{ old('appointment_date', request('date')) }}"
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
                <p id="appointment_time_hint" class="text-muted mt-1 mb-0" style="font-size: 12px;"></p>
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

<script>
    (function () {
        const dateInput = document.getElementById('appointment_date');
        const timeSelect = document.getElementById('appointment_time');
        const selectedDateDisplay = document.getElementById('selected_date_display');
        const timeHint = document.getElementById('appointment_time_hint');
        if (!dateInput || !timeSelect) return;

        const options = Array.from(timeSelect.options).filter((option) => option.value !== '');
        options.forEach((option) => {
            option.dataset.baseLabel = option.textContent.trim();
        });

        function updateSelectedDateDisplay() {
            if (!selectedDateDisplay) return;
            if (!dateInput.value) {
                selectedDateDisplay.classList.add('is-empty');
                selectedDateDisplay.innerHTML = `
                    <div class="selected-date-icon" aria-hidden="true">&#128197;</div>
                    <div class="selected-date-content">
                        <p class="selected-date-label">Selected date</p>
                        <p class="selected-date-value">Please choose a date.</p>
                    </div>
                `;
                return;
            }

            const date = new Date(dateInput.value + 'T00:00:00');
            const weekday = date.toLocaleDateString('en-US', {
                weekday: 'long'
            });
            const prettyDate = date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            selectedDateDisplay.classList.remove('is-empty');
            selectedDateDisplay.innerHTML = `
                <div class="selected-date-icon" aria-hidden="true">&#10003;</div>
                <div class="selected-date-content">
                    <p class="selected-date-label">Selected date</p>
                    <p class="selected-date-value">${prettyDate}</p>
                    <p class="selected-date-day">${weekday}</p>
                </div>
            `;
        }

        function resetTimeOptions() {
            options.forEach((option) => {
                option.disabled = false;
                option.textContent = `${option.dataset.baseLabel} - Available`;
            });
        }

        function updateTimeHint(bookedCount, selectedDate) {
            if (!timeHint) return;
            if (!selectedDate) {
                timeHint.textContent = 'Pick a date to load available time slots.';
                return;
            }
            timeHint.textContent = bookedCount > 0
                ? `${bookedCount} slot(s) are already taken on this date.`
                : 'All time slots are available on this date.';
        }

        async function refreshBookedSlots() {
            const selectedDate = dateInput.value;
            updateSelectedDateDisplay();
            resetTimeOptions();

            if (!selectedDate) {
                updateTimeHint(0, selectedDate);
                return;
            }

            try {
                const response = await fetch(`{{ panel_route('appointments.booked-slots') }}?date=${encodeURIComponent(selectedDate)}`);
                if (!response.ok) {
                    updateTimeHint(0, selectedDate);
                    return;
                }

                const data = await response.json();
                const booked = new Set((data.booked || []).map(String));
                let bookedCount = 0;

                options.forEach((option) => {
                    if (booked.has(option.value)) {
                        option.disabled = true;
                        option.textContent = `${option.dataset.baseLabel} - Taken`;
                        bookedCount++;
                    }
                });

                if (timeSelect.value && timeSelect.selectedOptions[0]?.disabled) {
                    timeSelect.value = '';
                }

                updateTimeHint(bookedCount, selectedDate);
            } catch (error) {
                updateTimeHint(0, selectedDate);
            }
        }

        dateInput.addEventListener('change', refreshBookedSlots);
        refreshBookedSlots();
    })();
</script>
@endsection
