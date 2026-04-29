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
        .client-look .avail-dot-full { background: #ef4444; }
        .client-look .avail-dot-past { background: #94a3b8; }
        .client-look .avail-note { margin: 0.75rem 0 0; font-size: 0.8125rem; }
        .client-look .avail-cal-header { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; }
        .client-look .avail-nav { display: flex; flex-wrap: wrap; gap: 0.5rem; }
        .client-look .avail-cal { border-top: 1px solid var(--client-border); }
        .client-look .avail-cal-row { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); border-bottom: 1px solid var(--client-border); }
        .client-look .avail-cal-head { background: #fafbfc; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--client-muted); }
        .client-look .avail-cal-cell { min-height: 4.5rem; padding: 0.5rem; display: flex; flex-direction: column; align-items: flex-start; gap: 0.15rem; border-right: 1px solid var(--client-border); text-decoration: none; color: inherit; box-sizing: border-box; }
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
        .client-look .avail-cal-open { background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e; cursor: pointer; transition: all 0.2s ease; }
        .client-look .avail-cal-open .avail-cal-tag { background: #dcfce7; color: #15803d; }
        .client-look .avail-cal-open:hover { background: #dcfce7; text-decoration: none; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); z-index: 10; }
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
                                    </div>
                                @else
                                    <a href="{{ route('admin.appointments.create', ['date' => $cell['date_str']]) }}" class="avail-cal-cell avail-cal-open">
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
