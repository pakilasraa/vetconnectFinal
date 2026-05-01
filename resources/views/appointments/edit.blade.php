@extends('layouts.valex')
@section('page-title', 'Edit Appointment')

@section('content')
    <div class="xl:col-span-12 col-span-12">

        <div class="box custom-box mt-3">
            <div class="box-header">
                <div class="box-title">Appointment Details</div>
            </div>
            <form action="{{ panel_route('appointments.update', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="box-body">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="xl:col-span-6 col-span-12">
                            <label class="form-label">Reference #</label>
                            <input type="text" class="form-control" value="{{ $appointment->reference_number ?: ('#'.$appointment->id) }}" readonly>
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="user_id" class="form-label">Pet Owner</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ old('user_id', $appointment->user_id) == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="pet_id" class="form-label">Pet</label>
                            <select name="pet_id" id="pet_id" class="form-control" required>
                                @foreach($pets as $pet)
                                    <option
                                        value="{{ $pet->id }}"
                                        data-owner-id="{{ $pet->owner_id }}"
                                        {{ old('pet_id', $appointment->pet_id) == $pet->id ? 'selected' : '' }}
                                    >
                                        {{ $pet->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pet_id') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="appointment_date" class="form-label">Appointment Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required value="{{ old('appointment_date', $appointment->appointment_date) }}">
                            @error('appointment_date') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="appointment_time" class="form-label">Appointment Time</label>
                            <select name="appointment_time" id="appointment_time" class="form-control" required>
                                @foreach(\App\Support\AppointmentSlots::times() as $time)
                                    @php
                                        $timeObj = \Carbon\Carbon::createFromFormat('H:i:s', $time);
                                    @endphp
                                    <option value="{{ $time }}" {{ old('appointment_time', $appointment->appointment_time) == $time ? 'selected' : '' }}>
                                        {{ $timeObj->format('g:i A') }}
                                    </option>
                                @endforeach
                            </select>
                            <p id="appointment_time_hint" class="text-muted mt-1 mb-0" style="font-size: 12px;"></p>
                            @error('appointment_time')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="service_type" class="form-label">Service Type</label>
                            <select name="service_type" id="service_type" class="form-control" required>
                                <option value="Consultation" {{ old('service_type', $appointment->service_type) == 'Consultation' ? 'selected' : '' }}>Consultation</option>
                                <option value="Vaccination" {{ old('service_type', $appointment->service_type) == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                                <option value="Surgery" {{ old('service_type', $appointment->service_type) == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                                <option value="Grooming" {{ old('service_type', $appointment->service_type) == 'Grooming' ? 'selected' : '' }}>Grooming</option>
                                <option value="Check-up" {{ old('service_type', $appointment->service_type) == 'Check-up' ? 'selected' : '' }}>Check-up</option>
                            </select>
                            @error('service_type') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="xl:col-span-12 col-span-12">
                            <label for="notes" class="form-label">Additional Notes (Optional)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ $appointment->notes }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-end">
                    <a href="{{ panel_route('appointments.index') }}" class="ti-btn ti-btn-light">Cancel</a>
                    <button type="submit" class="ti-btn ti-btn-primary">Update Appointment</button>
                </div>
            </form>
        </div>
    </div>

    @if(!auth()->user()->isPetOwner())
        <script>
            (function () {
                const ownerSelect = document.getElementById('user_id');
                const petSelect = document.getElementById('pet_id');
                if (!ownerSelect || !petSelect) return;

                const petOptions = Array.from(petSelect.options).filter((option) => option.value !== '');

                function filterPets() {
                    const ownerId = ownerSelect.value;
                    const selectedPet = petSelect.value;

                    petOptions.forEach((option) => {
                        const shouldShow = !ownerId || option.dataset.ownerId === ownerId;
                        option.hidden = !shouldShow;
                        option.disabled = !shouldShow;
                    });

                    if (selectedPet) {
                        const selectedOption = petOptions.find((option) => option.value === selectedPet);
                        if (selectedOption && (selectedOption.hidden || selectedOption.disabled)) {
                            petSelect.value = '';
                        }
                    }
                }

                ownerSelect.addEventListener('change', filterPets);
                filterPets();
            })();
        </script>
    @endif

    <script>
        (function () {
            const dateInput = document.getElementById('appointment_date');
            const timeSelect = document.getElementById('appointment_time');
            const hint = document.getElementById('appointment_time_hint');
            if (!dateInput || !timeSelect) return;

            const options = Array.from(timeSelect.options).filter((option) => option.value !== '');

            function toApiDate(value) {
                if (!value) return '';
                if (value.includes('-')) return value;
                const parts = value.split('/');
                if (parts.length === 3) {
                    return [parts[2], parts[1], parts[0]].join('-');
                }
                return value;
            }

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
                const selectedDate = toApiDate(dateInput.value);
                options.forEach((option) => {
                    option.disabled = false;
                    option.textContent = option.textContent.replace(' (Taken)', '');
                });

                if (!selectedDate) {
                    updateTimeHint(0);
                    return;
                }

                try {
                    const response = await fetch(`{{ route('admin.appointments.booked-slots') }}?date=${encodeURIComponent(selectedDate)}&exclude_id={{ $appointment->id }}`);
                    if (!response.ok) return;

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
