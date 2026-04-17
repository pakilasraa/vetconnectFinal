@extends('layouts.client-app')

@section('title', $pet->name.' - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $pet->name }}</h1>
        <p class="page-subtitle">{{ $pet->species }} @if($pet->breed) &middot; {{ $pet->breed }} @endif</p>
    </div>
    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
        <a href="{{ panel_route('pets.index') }}" class="btn btn-outline">Back to pets</a>
        <a href="{{ panel_route('pets.edit', $pet) }}" class="btn btn-primary">Edit</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Basic information</h2>
    </div>
    <div class="card-body">
        <div class="client-table-wrap">
            <table class="client-table">
                <tbody>
                    <tr>
                        <th scope="row" style="width: 40%;">Owner</th>
                        <td>{{ $pet->owner->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Gender</th>
                        <td>{{ $pet->gender ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Birth date</th>
                        <td>{{ $pet->birth_date ? \Carbon\Carbon::parse($pet->birth_date)->format('M d, Y') : '—' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Weight</th>
                        <td>{{ $pet->weight ? $pet->weight.' kg' : '—' }}</td>
                    </tr>
                    @if($pet->medical_history)
                        <tr>
                            <th scope="row">Notes</th>
                            <td>{{ $pet->medical_history }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Medical consultations</h2>
        <a href="{{ route('client.medical-records.index') }}" class="link">View all</a>
    </div>
    <div class="card-body" style="padding: 0;">
        @if($pet->medicalRecords->isEmpty())
            <p class="text-muted" style="padding: 1.25rem;">No consultation records for this pet.</p>
        @else
            <div class="client-table-wrap">
                <table class="client-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Diagnosis</th>
                            <th>Veterinarian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pet->medicalRecords->sortByDesc('visit_date')->take(10) as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->visit_date)->format('M d, Y') }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($record->diagnosis, 60) }}</td>
                                <td>{{ $record->vet->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Vaccinations</h2>
        <a href="{{ route('client.vaccination-records.index') }}" class="link">View all</a>
    </div>
    <div class="card-body" style="padding: 0;">
        @if($pet->vaccinationRecords->isEmpty())
            <p class="text-muted" style="padding: 1.25rem;">No vaccination records for this pet.</p>
        @else
            <div class="client-table-wrap">
                <table class="client-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Vaccine</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pet->vaccinationRecords->sortByDesc('administered_date') as $vax)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($vax->administered_date)->format('M d, Y') }}</td>
                                <td>{{ $vax->vaccine_name }}</td>
                                <td>
                                    @if($vax->status === 'given')
                                        <span class="badge badge-confirmed">Given</span>
                                    @else
                                        <span class="badge badge-pending">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Appointments</h2>
        <a href="{{ route('client.appointments.index') }}" class="link">View all</a>
    </div>
    <div class="card-body" style="padding: 0;">
        @php $appts = $pet->appointments->sortByDesc('appointment_date'); @endphp
        @if($appts->isEmpty())
            <p class="text-muted" style="padding: 1.25rem;">No appointments yet.</p>
        @else
            <div class="client-table-wrap">
                <table class="client-table">
                    <thead>
                        <tr>
                            <th>Date / time</th>
                            <th>Service</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appts->take(15) as $appointment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }} {{ $appointment->appointment_time }}</td>
                                <td>{{ $appointment->service_type }}</td>
                                <td>
                                    @php $st = strtolower((string) $appointment->status); @endphp
                                    <span class="badge @if($st === 'completed') badge-completed @elseif($st === 'cancelled') badge-cancelled @elseif($st === 'confirmed') badge-confirmed @else badge-pending @endif">{{ $appointment->status }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
