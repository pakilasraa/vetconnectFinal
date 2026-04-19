@extends('layouts.client-app')

@section('title', 'My Pets - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">My Pets</h1>
        <p class="page-subtitle">Manage your beloved companions</p>
    </div>
    <a href="{{ panel_route('pets.create') }}" class="btn btn-primary">+ Add Pet</a>
</div>

@if($pets->count() > 0)
    <div class="pets-grid-large">
        @foreach($pets as $pet)
            <div class="pet-card">
                <div class="pet-card-header">
                    <div class="pet-card-avatar">{{ substr($pet->name, 0, 1) }}</div>
                    <div class="pet-card-info">
                        <h2 class="pet-card-name">{{ $pet->name }}</h2>
                        <p class="pet-card-breed">{{ $pet->breed }}</p>
                        <div class="pet-card-badges">
                            <span class="badge badge-blue">{{ $pet->species }}</span>
                            <span class="badge badge-purple">{{ $pet->gender }}</span>
                        </div>
                    </div>
                    <div class="pet-favorite" aria-hidden="true">&hearts;</div>
                </div>

                <div class="pet-card-details">
                    <div class="detail-row">
                        <div class="detail-item">
                            <p class="detail-label">Age</p>
                            <p class="detail-value">{{ $pet->age ?? 'N/A' }}</p>
                        </div>
                        <div class="detail-item">
                            <p class="detail-label">Weight</p>
                            <p class="detail-value">{{ $pet->weight ? $pet->weight.' kg' : 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="pet-card-actions">
                    <a href="{{ panel_route('pets.show', $pet) }}" class="btn btn-outline flex-1">View Details</a>
                    <a href="{{ panel_route('appointments.create') }}" class="btn btn-primary flex-1">Book Appointment</a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-icon" aria-hidden="true">&#128062;</div>
        <h3 class="empty-title">No pets yet</h3>
        <p class="empty-text">Add your first pet to get started.</p>
        <a href="{{ panel_route('pets.create') }}" class="btn btn-primary">Add Pet</a>
    </div>
@endif

<section id="medical-records" class="client-section-anchor">
    <div class="page-header" style="margin-top: 2.5rem;">
        <div>
            <h2 class="page-title" style="font-size: 1.35rem;">Medical consultations</h2>
            <p class="page-subtitle">Consultation history for all your pets</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="padding: 0;">
            @if($medicalRecords->isEmpty())
                <p class="text-muted" style="padding: 1.25rem;">No medical records yet.</p>
            @else
                <div class="client-table-wrap">
                    <table class="client-table">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Pet</th>
                                <th scope="col">Diagnosis</th>
                                <th scope="col">Veterinarian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicalRecords as $record)
                                <tr>
                                    <td>{{ $record->visit_date->format('D') }}, {{ $record->visit_date->format('M j, Y') }}</td>
                                    <td>
                                        <a href="{{ panel_route('pets.show', $record->pet_id) }}">{{ $record->pet->name }}</a>
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($record->diagnosis, 80) }}</td>
                                    <td>{{ $record->vet->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
