@extends('layouts.client-app')

@section('title', 'Medical Records - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Medical Records</h1>
        <p class="page-subtitle">View and manage your pet's medical history</p>
    </div>
</div>

<!-- Filters -->
<div class="card">
    <form action="{{ panel_route('medical-records.index') }}" method="GET" class="filters-form">
        <div class="form-row">
            <div class="form-group">
                <label for="search" class="form-label">Search</label>
                <input type="text" id="search" name="search" value="{{ $search }}"
                       placeholder="Search records..." class="form-input">
            </div>

            <div class="form-group">
                <label for="pet" class="form-label">Pet</label>
                <select id="pet" name="pet" class="form-input">
                    <option value="all">All Pets</option>
                    @foreach($pets as $pet)
                        <option value="{{ $pet->name }}" {{ $petFilter == $pet->name ? 'selected' : '' }}>
                            {{ $pet->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="type" class="form-label">Type</label>
                <select id="type" name="type" class="form-input">
                    <option value="all">All Types</option>
                    <option value="checkup" {{ $typeFilter == 'checkup' ? 'selected' : '' }}>Checkup</option>
                    <option value="vaccination" {{ $typeFilter == 'vaccination' ? 'selected' : '' }}>Vaccination</option>
                    <option value="surgery" {{ $typeFilter == 'surgery' ? 'selected' : '' }}>Surgery</option>
                    <option value="lab-results" {{ $typeFilter == 'lab-results' ? 'selected' : '' }}>Lab Results</option>
                    <option value="prescription" {{ $typeFilter == 'prescription' ? 'selected' : '' }}>Prescription</option>
                    <option value="dental" {{ $typeFilter == 'dental' ? 'selected' : '' }}>Dental</option>
                </select>
            </div>

            <div class="form-group" style="display: flex; align-items: flex-end;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Apply Filters</button>
            </div>
        </div>
    </form>
</div>

<!-- Records List -->
@if($records->count() > 0)
    <div class="records-list-full">
        @foreach($records as $record)
            <div class="record-card">
                <div class="record-icon-large record-{{ $record->type_color }}">
                    📄
                </div>

                <div class="record-main">
                    <div class="record-header">
                        <h3 class="record-title-large">{{ $record->title }}</h3>
                        <span class="badge badge-gray">{{ $record->pet->name }}</span>
                    </div>

                    <p class="record-description">{{ $record->description }}</p>

                    <div class="record-meta-grid">
                        <span>📅 {{ $record->formatted_date }}</span>
                        <span>👨‍⚕️ {{ $record->doctor }}</span>
                        @if($record->attachments_count > 0)
                            <span>📎 {{ $record->attachments_count }} attachment{{ $record->attachments_count > 1 ? 's' : '' }}</span>
                        @endif
                    </div>
                </div>

                <div class="record-actions">
                    <a href="{{ panel_route('medical-records.show', $record) }}" class="btn btn-outline btn-sm">👁️ View</a>
                    <a href="{{ panel_route('medical-records.download', $record) }}" class="btn btn-outline btn-sm">⬇️ Download</a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-icon">📄</div>
        <h3 class="empty-title">No records found</h3>
        <p class="empty-text">Try adjusting your search or filters</p>
    </div>
@endif

<!-- Summary Stats -->
<div class="stats-grid" style="margin-top: 2rem;">
    <div class="stat-card">
        <div class="stat-icon stat-icon-blue">
            📄
        </div>
        <div class="stat-label">Total Records</div>
        <div class="stat-value">{{ $stats['total'] }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon-green">
            💉
        </div>
        <div class="stat-label">Vaccinations</div>
        <div class="stat-value">{{ $stats['vaccinations'] }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-icon-purple">
            📊
        </div>
        <div class="stat-label">Checkups</div>
        <div class="stat-value">{{ $stats['checkups'] }}</div>
    </div>
</div>
@endsection
