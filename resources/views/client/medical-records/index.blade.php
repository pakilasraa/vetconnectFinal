@extends('layouts.client-app')

@section('title', 'Medical records - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Medical consultations</h1>
        <p class="page-subtitle">Consultation history for your pets</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Consultation records</h2>
    </div>
    <div class="card-body" style="padding: 0;">
        @if($records->isEmpty())
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
                        @foreach($records as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->visit_date)->format('M d, Y') }}</td>
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
@endsection
