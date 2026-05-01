@extends('layouts.valex')
@section('page-title', 'Appointment calendar')

@section('content')
    <style>
        .client-look {
            --client-bg: #f0f4f8;
            --client-surface: #ffffff;
            --client-border: #e2e8f0;
            --client-text: #1e293b;
            --client-muted: #64748b;
            --client-primary: #0d9488;
            --client-primary-hover: #0f766e;
            --client-primary-soft: rgba(13, 148, 136, 0.12);
        }
        .client-look .page-header { display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem; }
        .client-look .page-title { margin: 0 0 0.25rem; font-size: 1.75rem; font-weight: 700; letter-spacing: -0.02em; color: var(--client-text); }
        .client-look .page-subtitle { margin: 0; color: var(--client-muted); font-size: 0.9375rem; }
        .client-look .page-header-actions { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
        .client-look .card { background: var(--client-surface); border-radius: 12px; border: 1px solid var(--client-border); box-shadow: 0 1px 3px rgba(15, 23, 42, 0.08); margin-bottom: 1.25rem; overflow: hidden; }
        .client-look .card-header { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; padding: 1rem 1.25rem; border-bottom: 1px solid var(--client-border); background: #fafbfc; }
        .client-look .card-title { margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--client-text); }
        .client-look .card-body { padding: 1.25rem; }
        .client-look .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.35rem; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 600; border-radius: 8px; border: 1px solid transparent; cursor: pointer; text-decoration: none; transition: background 0.15s, border-color 0.15s, color 0.15s; }
        .client-look .btn:hover { text-decoration: none; }
        .client-look .btn-primary { background: var(--client-primary); color: #fff; border-color: var(--client-primary); }
        .client-look .btn-primary:hover { background: var(--client-primary-hover); border-color: var(--client-primary-hover); color: #fff; }
        .client-look .btn-outline { background: transparent; border-color: var(--client-border); color: var(--client-text); }
        .client-look .btn-outline:hover { background: var(--client-bg); color: var(--client-text); }
        .client-look .btn-sm { padding: 0.35rem 0.65rem; font-size: 0.8125rem; }
        .client-look .text-muted { color: var(--client-muted); font-size: 0.9375rem; }
        .client-look .avail-legend-card .card-body { padding-bottom: 0.5rem; }
        .client-look .avail-legend { display: flex; flex-wrap: wrap; gap: 1rem 1.5rem; font-size: 0.875rem; color: var(--client-text); }
        .client-look .avail-dot { display: inline-block; width: 0.8rem; height: 0.8rem; border-radius: 4px; margin-right: 0.5rem; vertical-align: middle; box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1); }
        .client-look .avail-dot-available { background: #22c55e; }
        .client-look .avail-dot-booked { background: #f59e0b; }
        .client-look .avail-dot-full { background: #ef4444; }
        .client-look .avail-dot-past { background: #94a3b8; }
        .client-look .avail-note { margin: 0.75rem 0 0; font-size: 0.8125rem; }
        .client-look .avail-cal-header { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; }
        .client-look .avail-nav { display: flex; flex-wrap: wrap; gap: 0.5rem; }
        .client-look .avail-cal { border-top: 1px solid var(--client-border); }
        .client-look .avail-cal-row { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); border-bottom: 1px solid var(--client-border); }
        .client-look .avail-cal-head { background: #fafbfc; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--client-muted); }
        .client-look .avail-cal-cell { min-height: 6rem; padding: 0.5rem; display: flex; flex-direction: column; align-items: flex-start; gap: 0.15rem; border-right: 1px solid var(--client-border); text-decoration: none; color: inherit; box-sizing: border-box; }
        .client-look .avail-cal-row .avail-cal-cell:last-child { border-right: none; }
        .client-look .avail-cal-dow { min-height: auto; padding: 0.65rem 0.5rem; justify-content: center; align-items: center; text-align: center; }
        .client-look .avail-cal-dlabel { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; color: var(--client-muted); }
        .client-look .avail-cal-num { font-size: 1.125rem; font-weight: 700; }
        .client-look .avail-cal-tag { display: inline-block; padding: 0.15rem 0.5rem; border-radius: 6px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem; }
        .client-look .avail-cal-sub { font-size: 0.65rem; color: var(--client-muted); }
        .client-look .avail-cal-muted { background: #f8fafc; color: #cbd5e1; }
        .client-look .avail-cal-past { background: #f8fafc; color: #64748b; border-left: 4px solid #cbd5e1; }
        .client-look .avail-cal-past .avail-cal-tag { background: #f1f5f9; color: #475569; }
        .client-look .avail-cal-full { background: #fff1f2; color: #991b1b; border-left: 4px solid #f43f5e; }
        .client-look .avail-cal-full .avail-cal-tag { background: #ffe4e6; color: #be123c; }
        .client-look .avail-cal-booked { background: #fffbeb; color: #92400e; border-left: 4px solid #f59e0b; cursor: pointer; transition: all 0.2s ease; }
        .client-look .avail-cal-booked .avail-cal-tag { background: #fef3c7; color: #b45309; }
        .client-look .avail-cal-booked:hover { background: #fef3c7; text-decoration: none; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); z-index: 10; }
        .client-look .avail-cal-open { background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e; cursor: pointer; transition: all 0.2s ease; }
        .client-look .avail-cal-open .avail-cal-tag { background: #dcfce7; color: #15803d; }
        .client-look .avail-cal-open:hover { background: #dcfce7; text-decoration: none; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); z-index: 10; }

        /* Appointment list (selected day) */
        .client-look .appointments-list-full {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .client-look .appointment-card {
            border: 1px solid var(--client-border);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            background: #fafbfc;
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }
        .client-look .appointment-main {
            flex: 1;
            min-width: 0;
        }
        .client-look .appointment-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }
        .client-look .appointment-pet-name {
            margin: 0;
            font-size: 1.0625rem;
            font-weight: 600;
        }
        .client-look .appointment-type-text {
            margin: 0.35rem 0 0;
            font-size: 0.875rem;
            color: var(--client-muted);
        }
        .client-look .appointment-meta-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem 1.25rem;
            margin-top: 0.5rem;
            font-size: 0.8125rem;
            color: var(--client-muted);
        }
        .client-look .appointment-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Mini event pills inside calendar cells */
        .client-look .cal-day-events {
            width: 100%;
            margin-top: 0.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .client-look .cal-event-pill {
            width: 100%;
            padding: 0.18rem 0.35rem;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 700;
            display: flex;
            gap: 0.35rem;
            align-items: baseline;
            white-space: nowrap;
            overflow: hidden;
        }

        .client-look .cal-event-pill--pending {
            background: rgba(245, 158, 11, 0.18);
            color: #92400e;
        }

        .client-look .cal-event-pill--confirmed {
            background: rgba(34, 197, 94, 0.14);
            color: #166534;
        }

        .client-look .cal-event-pill--service-consultation {
            background: rgba(59, 130, 246, 0.16);
            color: #1d4ed8;
        }

        .client-look .cal-event-pill--service-vaccination {
            background: rgba(16, 185, 129, 0.16);
            color: #047857;
        }

        .client-look .cal-event-pill--service-check-up {
            background: rgba(245, 158, 11, 0.18);
            color: #92400e;
        }

        .client-look .cal-event-pill--service-surgery {
            background: rgba(244, 63, 94, 0.16);
            color: #be123c;
        }

        .client-look .cal-event-pill--service-grooming {
            background: rgba(139, 92, 246, 0.16);
            color: #6d28d9;
        }

        .client-look .cal-event-pill--service-other {
            background: rgba(148, 163, 184, 0.2);
            color: #334155;
        }

        .client-look .cal-event-time {
            font-variant-numeric: tabular-nums;
            color: inherit;
            opacity: 0.95;
        }

        .client-look .cal-event-label {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .client-look .cal-event-more {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--client-muted);
            padding-left: 0.25rem;
        }

        /* Status badges */
        .client-look .badge {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-radius: 6px;
        }
        .client-look .badge-pending { background: #fef3c7; color: #b45309; }
        .client-look .badge-confirmed { background: #d1fae5; color: #047857; }
        .client-look .badge-completed { background: #e0e7ff; color: #4338ca; }
        .client-look .badge-cancelled { background: #fee2e2; color: #b91c1c; }
    </style>

    <div class="client-look">
        <div class="page-header">
            <div>
                <h1 class="page-title">Appointment calendar</h1>
                <p class="page-subtitle">See open and full dates before booking admin appointments.</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">Book appointment</a>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline">List view</a>
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
                    <a href="{{ route('admin.appointments.calendar', ['year' => $prev->year, 'month' => $prev->month]) }}" class="btn btn-outline btn-sm">&larr; {{ $prev->translatedFormat('M Y') }}</a>
                    <a href="{{ route('admin.appointments.calendar', ['year' => now()->year, 'month' => now()->month]) }}" class="btn btn-outline btn-sm">This month</a>
                    <a href="{{ route('admin.appointments.calendar', ['year' => $next->year, 'month' => $next->month]) }}" class="btn btn-outline btn-sm">{{ $next->translatedFormat('M Y') }} &rarr;</a>
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
                                @if (! $cell['in_month'])
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
                                        @php $events = $appointmentsByDate[$cell['date_str']] ?? collect(); @endphp
                                        @if($events->count() > 0)
                                            <div class="cal-day-events">
                                                @foreach($events->take(2) as $evt)
                                                    @php $serviceClass = \Illuminate\Support\Str::slug((string) $evt->service_type) ?: 'other'; @endphp
                                                    <div class="cal-event-pill cal-event-pill--service-{{ $serviceClass }}">
                                                        <span class="cal-event-time">{{ \Carbon\Carbon::parse($evt->appointment_time)->format('g:i A') }}</span>
                                                        <span class="cal-event-label">{{ $evt->service_type }}</span>
                                                    </div>
                                                @endforeach
                                                @if($events->count() > 2)
                                                    <div class="cal-event-more">+{{ $events->count() - 2 }} more</div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @elseif ($cell['status'] === 'booked')
                                    <a href="{{ route('admin.appointments.create', ['date' => $cell['date_str']]) }}" class="avail-cal-cell avail-cal-booked">
                                        <span class="avail-cal-dlabel">{{ $d->format('D') }}</span>
                                        <span class="avail-cal-num">{{ $d->day }}</span>
                                        <span class="avail-cal-tag">Booked</span>
                                        <span class="avail-cal-sub">{{ $cell['used'] }}/{{ $cell['total'] }} taken</span>
                                        @php $events = $appointmentsByDate[$cell['date_str']] ?? collect(); @endphp
                                        @if($events->count() > 0)
                                            <div class="cal-day-events">
                                            @foreach($events->take(2) as $evt)
                                                    @php $serviceClass = \Illuminate\Support\Str::slug((string) $evt->service_type) ?: 'other'; @endphp
                                                    <div class="cal-event-pill cal-event-pill--service-{{ $serviceClass }}">
                                                        <span class="cal-event-time">{{ \Carbon\Carbon::parse($evt->appointment_time)->format('g:i A') }}</span>
                                                    <span class="cal-event-label">{{ $evt->service_type }}</span>
                                                    </div>
                                                @endforeach
                                                @if($events->count() > 2)
                                                    <div class="cal-event-more">+{{ $events->count() - 2 }} more</div>
                                                @endif
                                            </div>
                                        @endif
                                    </a>
                                @else
                                    <a href="{{ route('admin.appointments.create', ['date' => $cell['date_str']]) }}" class="avail-cal-cell avail-cal-open">
                                        <span class="avail-cal-dlabel">{{ $d->format('D') }}</span>
                                        <span class="avail-cal-num">{{ $d->day }}</span>
                                        <span class="avail-cal-tag">Open</span>
                                        <span class="avail-cal-sub">{{ $cell['used'] }}/{{ $cell['total'] }} taken</span>
                                        @php $events = $appointmentsByDate[$cell['date_str']] ?? collect(); @endphp
                                        @if($events->count() > 0)
                                            <div class="cal-day-events">
                                            @foreach($events->take(2) as $evt)
                                                    @php $serviceClass = \Illuminate\Support\Str::slug((string) $evt->service_type) ?: 'other'; @endphp
                                                    <div class="cal-event-pill cal-event-pill--service-{{ $serviceClass }}">
                                                        <span class="cal-event-time">{{ \Carbon\Carbon::parse($evt->appointment_time)->format('g:i A') }}</span>
                                                <span class="cal-event-label">{{ $evt->service_type }}</span>
                                                    </div>
                                                @endforeach
                                                @if($events->count() > 2)
                                                    <div class="cal-event-more">+{{ $events->count() - 2 }} more</div>
                                                @endif
                                            </div>
                                        @endif
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- List panel removed: appointments are shown as mini event pills inside each day cell. --}}
    </div>
@endsection
