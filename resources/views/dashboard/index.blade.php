@extends('layouts.app')

@section('title', 'Dashboard - VetConnect')

@section('content')
<!-- Welcome Section -->
<div class="page-header">
    <div>
        <h1 class="page-title">Welcome back, {{ auth()->user()->first_name }}!</h1>
        <p class="page-subtitle">Here's what's happening with your pets today.</p>
    </div>
</div>

<!-- Quick Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon stat-icon-blue">
            ❤️
        </div>
        <div class="stat-value">{{ $stats['total_pets'] }}</div>
        <div class="stat-label">Registered Pets</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon-green">
            📅
        </div>
        <div class="stat-value">{{ $stats['upcoming_appointments'] }}</div>
        <div class="stat-label">Upcoming Appointments</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon-purple">
            📄
        </div>
        <div class="stat-value">{{ $stats['total_records'] }}</div>
        <div class="stat-label">Recent Records</div>
    </div>
</div>

<!-- My Pets -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">My Pets</h2>
        <a href="{{ route('pets.index') }}" class="btn btn-primary">View All</a>
    </div>
    <div class="card-body">
        @if($pets->count() > 0)
            <div class="pets-grid">
                @foreach($pets as $pet)
                    <a href="{{ route('pets.show', $pet) }}" class="pet-item">
                        <div class="pet-avatar">
                            {{ substr($pet->name, 0, 1) }}
                        </div>
                        <div class="pet-info">
                            <h3 class="pet-name">{{ $pet->name }}</h3>
                            <p class="pet-details">{{ $pet->breed }} • {{ $pet->age }}</p>
                        </div>
                        <div class="pet-favorite">❤️</div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-muted">No pets registered yet. <a href="{{ route('pets.create') }}">Add your first pet</a></p>
        @endif
    </div>
</div>

<!-- Upcoming Appointments -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Upcoming Appointments</h2>
        <a href="{{ route('appointments.index') }}" class="btn btn-outline">View All</a>
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
                            <p class="appointment-type">{{ $appointment->type }}</p>
                            <div class="appointment-meta">
                                <span>📅 {{ $appointment->formatted_date }}</span>
                                <span>🕐 {{ $appointment->appointment_time }}</span>
                                <span>👨‍⚕️ {{ $appointment->doctor }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">No upcoming appointments. <a href="{{ route('appointments.create') }}">Book an appointment</a></p>
        @endif
    </div>
</div>

<!-- Recent Medical Records -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Recent Medical Records</h2>
        <a href="{{ route('medical-records.index') }}" class="link">View All</a>
    </div>
    <div class="card-body">
        @if($recentRecords->count() > 0)
            <div class="records-list">
                @foreach($recentRecords as $record)
                    <div class="record-item">
                        <div class="record-icon">
                            📄
                        </div>
                        <div class="record-content">
                            <h3 class="record-title">{{ $record->pet->name }} - {{ $record->title }}</h3>
                            <p class="record-meta">{{ $record->doctor }} • {{ $record->formatted_date }}</p>
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
