@extends('layouts.valex')
@section('page-title', 'Appointment Management')

@section('styles')
    <style>
        .appointment-status-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            padding: 0.2rem 0.55rem;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: capitalize;
            background-color: rgba(var(--primary-rgb), 0.12);
            color: rgb(var(--primary-rgb));
            border: 1px solid rgba(var(--primary-rgb), 0.28);
        }

        .appointment-status-badge--confirmed {
            background-color: rgba(var(--primary-rgb), 0.18);
            border-color: rgba(var(--primary-rgb), 0.34);
        }

        .appointment-status-badge--pending {
            background-color: rgba(var(--primary-rgb), 0.12);
            border-color: rgba(var(--primary-rgb), 0.28);
        }

        .appointment-status-badge--completed {
            background-color: rgba(var(--primary-rgb), 0.22);
            border-color: rgba(var(--primary-rgb), 0.38);
        }

        .appointment-status-badge--cancelled {
            background-color: rgba(var(--primary-rgb), 0.08);
            border-color: rgba(var(--primary-rgb), 0.2);
            opacity: 0.82;
        }

        .appointment-edit-action {
            color: rgb(var(--primary-rgb));
            transition: opacity 0.15s ease;
        }

        .appointment-edit-action:hover {
            color: rgb(var(--primary-rgb));
            opacity: 0.72;
        }

        .today-queue-wrap {
            border: 1px solid rgba(var(--primary-rgb), 0.18);
            background: rgba(var(--primary-rgb), 0.04);
            border-radius: 10px;
            padding: 0.75rem;
            margin-bottom: 0.9rem;
        }

        .today-queue-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgb(var(--text-muted));
            font-weight: 700;
            margin-bottom: 0.55rem;
        }

        .today-queue-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.45rem;
        }

        .today-queue-item {
            border: 1px solid rgba(var(--primary-rgb), 0.2);
            background: white;
            color: rgb(var(--primary-rgb));
            border-radius: 999px;
            font-size: 0.74rem;
            padding: 0.25rem 0.55rem;
            cursor: pointer;
            line-height: 1.15;
        }

        .today-queue-item:hover {
            background: rgba(var(--primary-rgb), 0.09);
        }

        .quick-one-click-wrap {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            margin-left: 0.25rem;
            font-size: 0.72rem;
            color: rgb(var(--text-muted));
            user-select: none;
        }

        .quick-one-click-wrap input[type="checkbox"] {
            width: 0.9rem;
            height: 0.9rem;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')

    <div class="xl:col-span-12 col-span-12">

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="box custom-box mt-3">
            <div class="box-header flex justify-between">
                <div class="box-title">
                    Upcoming Appointments
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <form id="quick-check-in-form" action="{{ route('admin.appointments.check-in') }}" method="POST" class="flex items-center gap-2 flex-wrap">
                        @csrf
                        @method('PATCH')
                        <input
                            id="quick-reference-number"
                            type="text"
                            name="reference_number"
                            class="form-control form-control-sm"
                            placeholder="Reference # (e.g. VC-20260501-ABC123)"
                            value="{{ old('reference_number') }}"
                            style="min-width: 230px;"
                            required
                        >
                        <select id="quick-check-in-status" name="status" class="form-control form-control-sm" required>
                            @foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $statusOption)
                                @php
                                    $statusLabel = [
                                        'pending' => 'Pending',
                                        'confirmed' => 'Checked-in',
                                        'completed' => 'Service Done',
                                        'cancelled' => 'Cancelled',
                                    ][$statusOption] ?? ucfirst($statusOption);
                                @endphp
                                <option value="{{ $statusOption }}" {{ old('status', 'confirmed') === $statusOption ? 'selected' : '' }}>
                                    {{ $statusLabel }}
                                </option>
                            @endforeach
                        </select>
                        <button id="quick-check-in-submit" type="submit" class="ti-btn ti-btn-success !py-1 !px-2 !font-medium !text-[0.75rem]">
                            Update by Ref
                        </button>
                        <label class="quick-one-click-wrap" title="When enabled, clicking Today queue item submits immediately.">
                            <input type="checkbox" id="quick-one-click-toggle">
                            <span>One-click update</span>
                        </label>
                    </form>
                    <a href="{{ route('admin.appointments.calendar') }}" class="ti-btn ti-btn-secondary !py-1 !px-2 !font-medium !text-[0.75rem]">
                        <i class="ri-calendar-2-line me-1"></i> Calendar
                    </a>
                    <form action="{{ panel_route('appointments.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search appointments..." value="{{ request('search') }}">
                        <button type="submit" class="ti-btn ti-btn-primary !py-1 !px-2 ms-2"><i class="ri-search-line"></i></button>
                    </form>
                    <a href="{{ panel_route('appointments.create') }}" class="ti-btn !py-1 !px-2 ti-btn-primary !font-medium !text-[0.75rem]">New
                        Appointment<i class="ri-add-circle-line ms-2 inline-block align-middle"></i></a>
                </div>
            </div>
            <div class="box-body">
                @if(isset($todayQueueAppointments) && $todayQueueAppointments->isNotEmpty())
                    <div class="today-queue-wrap">
                        <div class="today-queue-title">Today queue (quick pick)</div>
                        <div class="today-queue-list">
                            @foreach($todayQueueAppointments as $todayAppt)
                                <button
                                    type="button"
                                    class="today-queue-item"
                                    data-ref="{{ $todayAppt->reference_number }}"
                                    title="Use {{ $todayAppt->reference_number }}"
                                >
                                    {{ \Carbon\Carbon::parse($todayAppt->appointment_time)->format('g:i A') }} - {{ $todayAppt->pet->name }} - {{ $todayAppt->reference_number }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table whitespace-nowrap table-bordered min-w-full">
                        <thead>
                            <tr class="border-b border-defaultborder">
                                <th scope="col" class="text-start">Ref #</th>
                                <th scope="col" class="text-start">Pet</th>
                                <th scope="col" class="text-start">Owner</th>
                                <th scope="col" class="text-start">Date</th>
                                <th scope="col" class="text-start">Time</th>
                                <th scope="col" class="text-start">Service</th>
                                <th scope="col" class="text-start">Status</th>
                                <th scope="col" class="text-start">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr class="border-b border-defaultborder">
                                    <td>{{ $appointment->reference_number ?: ('#'.$appointment->id) }}</td>
                                    <td>{{ $appointment->pet->name }}</td>
                                    <td>{{ $appointment->owner->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('D') }}, {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M j, Y') }}</td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                    <td>{{ $appointment->service_type }}</td>
                                    <td>
                                        <span class="appointment-status-badge appointment-status-badge--{{ $appointment->status }}">
                                            {{ $appointment->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ panel_route('appointments.edit', $appointment->id) }}"
                                                class="appointment-edit-action text-[.875rem] leading-none">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ panel_route('appointments.destroy', $appointment->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger text-[.875rem] leading-none" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $appointments->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    (function () {
        const form = document.getElementById('quick-check-in-form');
        const referenceInput = document.getElementById('quick-reference-number');
        const submitBtn = document.getElementById('quick-check-in-submit');
        const oneClickToggle = document.getElementById('quick-one-click-toggle');
        const quickPickButtons = Array.from(document.querySelectorAll('.today-queue-item'));
        if (!form || !referenceInput || !submitBtn) return;

        function normalizeReference(value) {
            return String(value || '')
                .toUpperCase()
                .replace(/[^A-Z0-9-]/g, '');
        }

        window.requestAnimationFrame(() => {
            referenceInput.focus();
            referenceInput.select();
        });

        referenceInput.addEventListener('input', function () {
            const normalized = normalizeReference(referenceInput.value);
            if (referenceInput.value !== normalized) {
                referenceInput.value = normalized;
            }
        });

        referenceInput.addEventListener('keydown', function (event) {
            if (event.key !== 'Enter') return;
            event.preventDefault();
            if (!referenceInput.value.trim()) return;
            submitBtn.click();
        });

        form.addEventListener('submit', function () {
            referenceInput.value = normalizeReference(referenceInput.value).trim();
        });

        const oneClickStorageKey = 'appointments.quickOneClickUpdate';
        if (oneClickToggle) {
            oneClickToggle.checked = window.localStorage.getItem(oneClickStorageKey) === '1';
            oneClickToggle.addEventListener('change', function () {
                window.localStorage.setItem(oneClickStorageKey, oneClickToggle.checked ? '1' : '0');
            });
        }

        quickPickButtons.forEach((btn) => {
            btn.addEventListener('click', function () {
                referenceInput.value = normalizeReference(btn.dataset.ref || '');
                referenceInput.focus();
                referenceInput.select();

                if (!oneClickToggle || !oneClickToggle.checked) return;
                if (!referenceInput.value.trim()) return;

                const selectedStatus = document.getElementById('quick-check-in-status');
                const statusValue = selectedStatus ? selectedStatus.value : 'confirmed';
                const statusLabels = {
                    pending: 'Pending',
                    confirmed: 'Checked-in',
                    completed: 'Service Done',
                    cancelled: 'Cancelled'
                };
                const statusLabel = statusLabels[statusValue] || statusValue;
                const ok = window.confirm(`Update ${referenceInput.value} to "${statusLabel}" now?`);
                if (!ok) return;

                submitBtn.click();
            });
        });
    })();
</script>
@endsection
