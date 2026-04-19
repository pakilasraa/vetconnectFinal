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

<div class="card avail-legend-card">
    <div class="card-body avail-legend">
        <span><span class="avail-dot avail-dot-available"></span> Open — at least one time slot is free</span>
        <span><span class="avail-dot avail-dot-full"></span> Full — all standard slots are taken</span>
        <span><span class="avail-dot avail-dot-past"></span> Past — cannot book</span>
    </div>
    <p class="avail-note text-muted">A day is marked <strong>Full</strong> when there are already {{ $slotCount }} active appointments that day (clinic capacity). Cancelled visits do not count.</p>
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
@endsection
