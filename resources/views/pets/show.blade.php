@extends('layouts.valex')
@section('page-title', 'Pet Details')
@section('breadcrumb-parent', 'Pet Management')
@section('breadcrumb-child', 'Details')

@section('content')
    <div class="xl:col-span-12 col-span-12">

        <div class="grid grid-cols-12 gap-6 mt-3">
            {{-- Basic Info --}}
            <div class="xl:col-span-4 col-span-12">
                <div class="box custom-box">
                    <div class="box-header flex justify-between items-center">
                        <div class="box-title">Basic Information</div>
                        <a href="{{ panel_route('pets.edit', $pet) }}" class="ti-btn ti-btn-sm ti-btn-primary">Edit</a>
                    </div>
                    <div class="box-body p-0">
                        <table class="table table-sm mb-0">
                            <tbody>
                                <tr><th scope="row" class="text-start">Owner:</th><td>{{ $pet->owner->name }}</td></tr>
                                <tr><th scope="row" class="text-start">Species:</th><td>{{ $pet->species }}</td></tr>
                                <tr><th scope="row" class="text-start">Breed:</th><td>{{ $pet->breed ?? 'N/A' }}</td></tr>
                                <tr><th scope="row" class="text-start">Gender:</th><td>{{ $pet->gender ?? 'N/A' }}</td></tr>
                                <tr><th scope="row" class="text-start">Birth Date:</th><td>{{ $pet->birth_date ? \Carbon\Carbon::parse($pet->birth_date)->format('d M Y') : 'N/A' }}</td></tr>
                                <tr><th scope="row" class="text-start">Weight:</th><td>{{ $pet->weight ? $pet->weight . ' kg' : 'N/A' }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($pet->medical_history)
                <div class="box custom-box mt-4">
                    <div class="box-header">
                        <div class="box-title">General Medical History</div>
                    </div>
                    <div class="box-body">
                        <p class="text-textmuted">{{ $pet->medical_history }}</p>
                    </div>
                </div>
                @endif

                <div class="box custom-box mt-4">
                    <div class="box-header">
                        <div class="box-title">Clinical records</div>
                    </div>
                    <div class="box-body">
                        <p class="text-textmuted text-sm mb-3">Consultations and vaccinations are maintained in <strong>Medical Records</strong> (sidebar) so they stay in one place.</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.medical-records.index') }}" class="ti-btn ti-btn-soft-primary ti-btn-wave">Consultations</a>
                            <a href="{{ route('admin.vaccination-records.index') }}" class="ti-btn ti-btn-soft-info ti-btn-wave">Vaccinations</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Appointments for this pet only --}}
            <div class="xl:col-span-8 col-span-12">
                <div class="box custom-box">
                    <div class="box-header flex justify-between items-center">
                        <div class="box-title">Appointments (this pet)</div>
                        <a href="{{ panel_route('appointments.create') }}?pet_id={{ $pet->id }}&amp;user_id={{ $pet->owner_id }}" class="ti-btn ti-btn-sm ti-btn-primary">Book</a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered whitespace-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Date/Time</th>
                                        <th>Service</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pet->appointments->sortByDesc('appointment_date') as $appointment)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('D, M j, Y') }} {{ $appointment->appointment_time }}</td>
                                            <td>{{ $appointment->service_type }}</td>
                                            <td>
                                                <span class="badge {{ $appointment->status == 'confirmed' ? 'bg-success/10 text-success' : ($appointment->status == 'cancelled' ? 'bg-danger/10 text-danger' : 'bg-info/10 text-info') }}">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ panel_route('appointments.edit', $appointment) }}" class="text-info text-[.875rem]"><i class="ri-edit-line"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center">No appointments for this pet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
