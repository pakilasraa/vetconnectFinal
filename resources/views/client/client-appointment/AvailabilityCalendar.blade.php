@extends('layouts.client-app')

@section('title', 'Booking availability - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Booking availability</h1>
        <p class="page-subtitle">See which days still have open times before you book.</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('client.appointments.create') }}" class="btn btn-primary">Book appointment</a>
        <a href="{{ route('client.appointments.index') }}" class="btn btn-outline">My appointments</a>
    </div>
</div>

<div class="card avail-legend-card" style="border-left: 4px solid var(--client-primary);">
    <div class="card-body">
        <div class="avail-legend">
            <span class="legend-item"><span class="avail-dot avail-dot-available"></span> <strong>Open</strong> — Available for booking</span>
                <span class="legend-item"><span class="avail-dot avail-dot-booked"></span> <strong>Booked</strong> — Some slots taken</span>
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
            <a href="{{ route('client.appointments.availability', ['year' => $prev->year, 'month' => $prev->month]) }}" class="btn btn-outline btn-sm">&larr; {{ $prev->translatedFormat('M Y') }}</a>
            <a href="{{ route('client.appointments.availability', ['year' => now()->year, 'month' => now()->month]) }}" class="btn btn-outline btn-sm">This month</a>
            <a href="{{ route('client.appointments.availability', ['year' => $next->year, 'month' => $next->month]) }}" class="btn btn-outline btn-sm">{{ $next->translatedFormat('M Y') }} &rarr;</a>
        </div>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="avail-cal">
            <div class="avail-cal-row avail-cal-head">
                @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $dow)
                    <div class="avail-cal-cell avail-cal-dow">{{ $dow }}</div>
                @endforeach
            </div>
            @foreach ($weeks as $week)
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
                            <a href="{{ route('client.appointments.create', ['date' => $cell['date_str']]) }}" class="avail-cal-cell avail-cal-full">
                                <span class="avail-cal-dlabel">{{ $d->format('D') }}</span>
                                <span class="avail-cal-num">{{ $d->day }}</span>
                                <span class="avail-cal-tag">Full</span>
                            </a>
                        @elseif ($cell['status'] === 'booked')
                            <a href="{{ route('client.appointments.create', ['date' => $cell['date_str']]) }}" class="avail-cal-cell avail-cal-booked">
                                <span class="avail-cal-dlabel">{{ $d->format('D') }}</span>
                                <span class="avail-cal-num">{{ $d->day }}</span>
                                <span class="avail-cal-tag">Booked</span>
                                <span class="avail-cal-sub">{{ $cell['used'] }}/{{ $cell['total'] }} taken</span>
                            </a>
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
@endsection
