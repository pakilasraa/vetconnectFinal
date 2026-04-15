@extends('layouts.app')

@section('title', 'My Pets - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">My Pets</h1>
        <p class="page-subtitle">Manage your beloved companions</p>
    </div>
    <a href="{{ route('pets.create') }}" class="btn btn-primary">+ Add Pet</a>
</div>

@if($pets->count() > 0)
    <div class="pets-grid-large">
        @foreach($pets as $pet)
            <div class="pet-card">
                <div class="pet-card-header">
                    <div class="pet-card-avatar">
                        {{ substr($pet->name, 0, 1) }}
                    </div>
                    <div class="pet-card-info">
                        <h2 class="pet-card-name">{{ $pet->name }}</h2>
                        <p class="pet-card-breed">{{ $pet->breed }}</p>
                        <div class="pet-card-badges">
                            <span class="badge badge-blue">{{ $pet->species }}</span>
                            <span class="badge badge-purple">{{ $pet->gender }}</span>
                        </div>
                    </div>
                    <div class="pet-favorite">❤️</div>
                </div>

                <div class="pet-card-details">
                    <div class="detail-row">
                        <div class="detail-item">
                            <p class="detail-label">Age</p>
                            <p class="detail-value">{{ $pet->age ?? 'N/A' }}</p>
                        </div>
                        <div class="detail-item">
                            <p class="detail-label">Weight</p>
                            <p class="detail-value">{{ $pet->weight ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-item">
                            <p class="detail-label">Color</p>
                            <p class="detail-value">{{ $pet->color ?? 'N/A' }}</p>
                        </div>
                        <div class="detail-item">
                            <p class="detail-label">Microchip</p>
                            <p class="detail-value">{{ $pet->microchip ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                @if($pet->last_visit || $pet->next_vaccination)
                    <div class="pet-card-footer">
                        @if($pet->last_visit)
                            <div class="footer-info">
                                <span>📊</span> Last visit: <strong>{{ $pet->last_visit }}</strong>
                            </div>
                        @endif
                        @if($pet->next_vaccination)
                            <div class="footer-info">
                                <span>💉</span> Next vaccination: <strong>{{ $pet->next_vaccination }}</strong>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="pet-card-actions">
                    <a href="{{ route('pets.show', $pet) }}" class="btn btn-outline flex-1">View Details</a>
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary flex-1">Book Appointment</a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-icon">🐾</div>
        <h3 class="empty-title">No pets registered</h3>
        <p class="empty-text">Add your first pet to get started</p>
        <a href="{{ route('pets.create') }}" class="btn btn-primary">Add Pet</a>
    </div>
@endif
@endsection
