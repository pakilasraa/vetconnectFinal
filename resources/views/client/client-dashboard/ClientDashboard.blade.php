@extends('layouts.client-app')

@section('title', 'Dashboard - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="page-subtitle">Here's what's happening with your pets today.</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon stat-icon-blue">P</div>
        <div class="stat-value">{{ $stats['total_pets'] }}</div>
        <div class="stat-label">Registered Pets</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon-green">A</div>
        <div class="stat-value">{{ $stats['upcoming_appointments'] }}</div>
        <div class="stat-label">Upcoming Appointments</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon-purple">M</div>
        <div class="stat-value">{{ $stats['total_records'] }}</div>
        <div class="stat-label">Medical Records</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">My Pets</h2>
        <a href="{{ panel_route('pets.index') }}" class="btn btn-primary">View All</a>
    </div>
    <div class="card-body">
        @if($pets->count() > 0)
            <div class="pets-grid">
                @foreach($pets as $pet)
                    <a href="{{ panel_route('pets.show', $pet) }}" class="pet-item">
                        <div class="pet-avatar">{{ substr($pet->name, 0, 1) }}</div>
                        <div class="pet-info">
                            <h3 class="pet-name">{{ $pet->name }}</h3>
                            <p class="pet-details">{{ $pet->breed }} &middot; {{ $pet->age ?? 'Age N/A' }}</p>
                        </div>
                        <div class="pet-favorite" aria-hidden="true">&hearts;</div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-muted">No pets registered yet. <a href="{{ panel_route('pets.create') }}">Add your first pet</a></p>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Upcoming Appointments</h2>
        <a href="{{ panel_route('appointments.index') }}" class="btn btn-outline">View All</a>
    </div>
    <div class="card-body">
        @if($upcomingAppointments->count() > 0)
            <div class="appointments-list">
                @foreach($upcomingAppointments as $appointment)
                    <div class="appointment-item">
                        <div class="appointment-content">
                            <div class="appointment-header">
                                <h3 class="appointment-pet">{{ $appointment->pet->name }}</h3>
                                <span class="badge badge-{{ $appointment->status }}">{{ $appointment->status }}</span>
                            </div>
                            <p class="appointment-type">{{ $appointment->service_type }}</p>
                            <div class="appointment-meta">
                                <span>{{ $appointment->formatted_date }}</span>
                                <span>{{ $appointment->appointment_time }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">No upcoming appointments. <a href="{{ panel_route('appointments.create') }}">Book an appointment</a></p>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Recent Medical Records</h2>
        <a href="{{ panel_route('medical-records.index') }}" class="link">View All</a>
    </div>
    <div class="card-body">
        @if($recentRecords->count() > 0)
            <div class="records-list">
                @foreach($recentRecords as $record)
                    <div class="record-item">
                        <div class="record-icon" aria-hidden="true">&#128196;</div>
                        <div class="record-content">
                            <h3 class="record-title">{{ $record->pet->name }} &mdash; {{ \Illuminate\Support\Str::limit($record->diagnosis, 48) }}</h3>
                            <p class="record-meta">{{ $record->vet?->name }} &middot; {{ $record->visit_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">No medical records yet.</p>
        @endif
    </div>
</div>
@endsection
