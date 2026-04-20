@extends('layouts.valex')
@section('page-title', 'Appointment calendar')
@section('breadcrumb-parent', 'Appointments')
@section('breadcrumb-child', 'Full calendar')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/main.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.11/main.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.11/main.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.11/main.min.css">
    <style>
        #appointment-calendar { min-height: 38rem; }
        .fc .appointment-cancelled { opacity: 0.65; text-decoration: line-through !important; }
        .fc .fc-toolbar-title { font-size: 1.1rem; }
    </style>
@endsection

@section('content')
    <div class="grid grid-cols-12 gap-x-6">
        <div class="xl:col-span-3 col-span-12">
            <div class="box custom-box">
                <div class="py-4 px-[1.25rem] border-b dark:border-defaultborder/10 !grid">
                    <a href="{{ route('admin.appointments.create') }}" class="ti-btn ti-btn-soft-primary text-center">
                        <i class="ri-add-line align-middle me-1 font-semibold inline-block"></i>New appointment
                    </a>
                </div>
                <div class="box-body !p-0">
                    <div class="border-b dark:border-defaultborder/10 p-4">
                        <p class="text-textmuted text-[0.8125rem] mb-0">
                            Legend for common visit types. Appointments on the calendar come from your database; use <strong>New appointment</strong> or the list view to add or edit bookings.
                        </p>
                    </div>
                    <div id="external-events" class="border-b dark:border-defaultborder/10 p-4 space-y-2">
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event !bg-primary border !border-primary rounded px-2 py-1 text-sm">
                            <div class="fc-event-main">Consultation</div>
                        </div>
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event !bg-secondary border !border-secondary rounded px-2 py-1 text-sm">
                            <div class="fc-event-main">Vaccination</div>
                        </div>
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event !bg-success border !border-success rounded px-2 py-1 text-sm">
                            <div class="fc-event-main">Follow-up</div>
                        </div>
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event !bg-info border !border-info rounded px-2 py-1 text-sm">
                            <div class="fc-event-main">Grooming</div>
                        </div>
                    </div>
                    <div class="dark:border-defaultborder/10">
                        <div class="flex items-center mb-4 p-4 !pb-0 justify-between">
                            <h6 class="font-semibold mb-0">Upcoming activity</h6>
                            <a href="{{ route('admin.appointments.index') }}" class="ti-btn !py-1 !px-2 !text-[0.75rem] ti-btn-primary btn-wave">List view</a>
                        </div>
                        <ul class="list-none mb-0 !p-4 !pt-0 fullcalendar-events-activity" id="full-calendar-activity">
                            @forelse ($activity as $appt)
                                @php
                                    $dt = \Carbon\Carbon::parse($appt->appointment_date);
                                    $tm = \Carbon\Carbon::parse($appt->appointment_time);
                                @endphp
                                <li class="{{ !$loop->last ? 'mb-4 pb-4 border-b border-defaultborder dark:border-defaultborder/10' : '' }}">
                                    <div class="flex items-center justify-between flex-wrap gap-2">
                                        <p class="mb-1 font-semibold text-[0.875rem]">
                                            {{ $dt->translatedFormat('l') }}, {{ $dt->translatedFormat('M j, Y') }}
                                        </p>
                                        <span class="badge bg-light text-default mb-1">{{ $tm->format('g:i A') }}</span>
                                    </div>
                                    <p class="mb-1 text-[0.8125rem] font-medium">
                                        <a href="{{ route('admin.appointments.edit', $appt) }}" class="text-primary">{{ $appt->pet->name }}</a>
                                        — {{ $appt->service_type }}
                                    </p>
                                    <p class="mb-0 text-muted text-[0.75rem]">
                                        {{ $appt->owner->name }}
                                        <span class="badge {{ $appt->status === 'confirmed' ? 'bg-success/10 text-success' : ($appt->status === 'cancelled' ? 'bg-danger/10 text-danger' : 'bg-info/10 text-info') }} ms-1">{{ ucfirst($appt->status) }}</span>
                                    </p>
                                </li>
                            @empty
                                <li class="text-textmuted text-sm">No appointments in the loaded range.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="xl:col-span-9 col-span-12">
            <div class="box custom-box">
                <div class="box-header flex flex-wrap justify-between items-center gap-2">
                    <div class="box-title mb-0">Full calendar</div>
                </div>
                <div class="box-body">
                    <div id="calendar2"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var events = @json($events);

            var calendarEl = document.getElementById('calendar2');
            if (!calendarEl) return;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                navLinks: true,
                editable: false,
                selectable: false,
                dayMaxEvents: true,
                height: 'auto',
                events: events,
                eventClick: function (info) {
                    info.jsEvent.preventDefault();
                    var url = info.event.extendedProps && info.event.extendedProps.editUrl;
                    if (url) window.location.href = url;
                }
            });
            calendar.render();

            var act = document.getElementById('full-calendar-activity');
            if (act && typeof SimpleBar !== 'undefined') {
                new SimpleBar(act, { autoHide: true });
            }
        });
    </script>
@endsection
