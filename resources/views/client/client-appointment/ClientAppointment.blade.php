@extends('layouts.client-app')

@section('title', 'Appointments - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Appointments</h1>
        <p class="page-subtitle">Manage your pet's appointments and check availability</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ panel_route('appointments.create') }}" class="btn btn-primary">+ Book Appointment</a>
    </div>
</div>

{{-- ── Main tabs: My Appointments / Availability Calendar ── --}}
@php $activeTab = request('tab', 'appointments'); @endphp

<div class="tabs" style="margin-bottom: 0; border-bottom: none;">
    <a href="{{ panel_route('appointments.index', ['filter' => $filter]) }}"
       class="tab {{ $activeTab === 'appointments' ? 'active' : '' }}"
       id="tab-appointments">My Appointments</a>
    <a href="{{ panel_route('appointments.index', ['tab' => 'calendar', 'cal_year' => $calYear, 'cal_month' => $calMonth]) }}"
       class="tab {{ $activeTab === 'calendar' ? 'active' : '' }}"
       id="tab-calendar">Availability Calendar</a>
</div>

{{-- ════════════════════════════════════════════
     TAB 1 — My Appointments
════════════════════════════════════════════ --}}
<div id="panel-appointments" class="{{ $activeTab === 'appointments' ? '' : 'hidden' }}">

    <div class="tabs" style="margin-top: 1rem;">
        <a href="{{ panel_route('appointments.index', ['filter' => 'all']) }}"
           class="tab {{ $filter === 'all' ? 'active' : '' }}">All</a>
        <a href="{{ panel_route('appointments.index', ['filter' => 'upcoming']) }}"
           class="tab {{ $filter === 'upcoming' ? 'active' : '' }}">Upcoming</a>
        <a href="{{ panel_route('appointments.index', ['filter' => 'past']) }}"
           class="tab {{ $filter === 'past' ? 'active' : '' }}">Past</a>
    </div>

    @if($appointments->count() > 0)
        <div class="appointments-list-full">
            @foreach($appointments as $appointment)
                <div class="appointment-card">
                    <div class="appointment-main">
                        <div class="appointment-header">
                            <h3 class="appointment-pet-name">{{ $appointment->pet->name }}</h3>
                            <span class="badge badge-{{ $appointment->status }}">{{ $appointment->status }}</span>
                        </div>
                        <p class="appointment-type-text">{{ $appointment->service_type }}</p>
                        <div class="appointment-meta-grid">
                            <span>{{ $appointment->formatted_date }}</span>
                            <span>{{ $appointment->appointment_time }}</span>
                        </div>
                        @if($appointment->notes)
                            <div class="appointment-notes">{{ $appointment->notes }}</div>
                        @endif
                    </div>

                    @if($appointment->status !== 'completed' && $appointment->status !== 'cancelled')
                        <div class="appointment-actions">
                            <a href="{{ panel_route('appointments.edit', $appointment) }}" class="btn btn-outline btn-sm">Reschedule</a>
                            <form action="{{ panel_route('appointments.cancel', $appointment) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Cancel this appointment?')">Cancel</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon" aria-hidden="true">&#128197;</div>
            <h3 class="empty-title">No appointments found</h3>
            <p class="empty-text">You don't have any {{ $filter }} appointments.</p>
            <a href="{{ panel_route('appointments.create') }}" class="btn btn-primary">Book Your First Appointment</a>
        </div>
    @endif
</div>

{{-- ════════════════════════════════════════════
     TAB 2 — Availability Calendar
════════════════════════════════════════════ --}}
<div id="panel-calendar" class="{{ $activeTab === 'calendar' ? '' : 'hidden' }}">

    <div class="card avail-legend-card" style="margin-top: 1rem; border-left: 4px solid var(--client-primary);">
        <div class="card-body">
            <div class="avail-legend">
                <span class="legend-item"><span class="avail-dot avail-dot-available"></span> <strong>Open</strong> — Available for booking</span>
                <span class="legend-item"><span class="avail-dot avail-dot-full"></span> <strong>Full</strong> — Clinic at maximum capacity</span>
                <span class="legend-item"><span class="avail-dot avail-dot-past"></span> <strong>Past</strong> — Date has already passed</span>
            </div>
            <p class="avail-note text-muted" style="margin-top: 0.75rem;">
                <i class="ri-information-line me-1"></i> A day is marked <strong>Full</strong> when there are {{ $slotCount }} active appointments. Cancelled visits are not counted.
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header avail-cal-header">
            <h2 class="card-title mb-0">{{ $monthStart->translatedFormat('F Y') }}</h2>
            <div class="avail-nav">
                <a href="{{ panel_route('appointments.index', ['tab' => 'calendar', 'cal_year' => $calPrev->year, 'cal_month' => $calPrev->month]) }}"
                   class="btn btn-outline btn-sm">&larr; {{ $calPrev->translatedFormat('M Y') }}</a>
                <a href="{{ panel_route('appointments.index', ['tab' => 'calendar', 'cal_year' => now()->year, 'cal_month' => now()->month]) }}"
                   class="btn btn-outline btn-sm">This month</a>
                <a href="{{ panel_route('appointments.index', ['tab' => 'calendar', 'cal_year' => $calNext->year, 'cal_month' => $calNext->month]) }}"
                   class="btn btn-outline btn-sm">{{ $calNext->translatedFormat('M Y') }} &rarr;</a>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="avail-cal">
                <div class="avail-cal-row avail-cal-head">
                    @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $dow)
                        <div class="avail-cal-cell avail-cal-dow">{{ $dow }}</div>
                    @endforeach
                </div>
                @foreach ($calWeeks as $week)
                    <div class="avail-cal-row">
                        @foreach ($week as $cell)
                            @php $d = $cell['day']; @endphp
                            @if (!$cell['in_month'])
                                <div class="avail-cal-cell avail-cal-muted">
                                    <span class="avail-cal-num">{{ $d->day }}</span>
                                </div>
                            @elseif ($cell['status'] === 'past')
                                <div class="avail-cal-cell avail-cal-past">
                                    <span class="avail-cal-dlabel">{{ $d->format('D') }}</span>
                                    <span class="avail-cal-num">{{ $d->day }}</span>
                                    <span class="avail-cal-tag">Past</span>
                                </div>
                            @elseif ($cell['status'] === 'full')
                                <div class="avail-cal-cell avail-cal-full">
                                    <span class="avail-cal-dlabel">{{ $d->format('D') }}</span>
                                    <span class="avail-cal-num">{{ $d->day }}</span>
                                    <span class="avail-cal-tag">Full</span>
                                </div>
                            @else
                                <a href="{{ route('client.appointments.create', ['date' => $cell['date_str']]) }}" class="avail-cal-cell avail-cal-open">
                                    <span class="avail-cal-dlabel">{{ $d->format('D') }}</span>
                                    <span class="avail-cal-num">{{ $d->day }}</span>
                                    <span class="avail-cal-tag">Open</span>
                                    <span class="avail-cal-sub">{{ $cell['used'] }}/{{ $cell['total'] }} taken</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
