@extends('layouts.client-app')

@section('title', 'Vaccinations - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Vaccination records</h1>
        <p class="page-subtitle">Vaccination history for your pets</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Vaccination history</h2>
    </div>
    <div class="card-body" style="padding: 0;">
        @if($records->isEmpty())
            <p class="text-muted" style="padding: 1.25rem;">No vaccination records yet.</p>
        @else
            <div class="client-table-wrap">
                <table class="client-table">
                    <thead>
                        <tr>
                            <th scope="col">Date given</th>
                            <th scope="col">Pet</th>
                            <th scope="col">Vaccine</th>
                            <th scope="col">Next due</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->administered_date)->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ panel_route('pets.show', $record->pet_id) }}">{{ $record->pet->name }}</a>
                                </td>
                                <td>{{ $record->vaccine_name }}</td>
                                <td>{{ $record->due_date ? \Carbon\Carbon::parse($record->due_date)->format('M d, Y') : '—' }}</td>
                                <td>
                                    @if($record->status === 'given')
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
@endsection
