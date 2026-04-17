@extends('layouts.client-app')

@section('title', 'Appointments - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Appointments</h1>
        <p class="page-subtitle">Manage your pet's appointments</p>
    </div>
    <a href="{{ panel_route('appointments.create') }}" class="btn btn-primary">+ Book Appointment</a>
</div>

<div class="tabs">
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
@endsection
