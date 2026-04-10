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
                    <div class="box-header">
                        <div class="box-title">Basic Information</div>
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
            </div>

            {{-- Records Tabs --}}
            <div class="xl:col-span-8 col-span-12">
                <div class="box custom-box">
                    <div class="box-header border-b-0">
                        <ul class="nav nav-tabs card-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#medical-records" role="tab">Medical Records</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#vaccinations" role="tab">Vaccinations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#appointments" role="tab">Appointments</a>
                            </li>
                        </ul>
                    </div>
                    <div class="box-body">
                        <div class="tab-content">
                            {{-- Medical Records --}}
                            <div class="tab-pane active" id="medical-records" role="tabpanel">
                                @if(in_array(auth()->user()->role, ['vet', 'staff', 'admin']))
                                <div class="mb-3 text-end">
                                    <button class="ti-btn ti-btn-primary-full ti-btn-wave" data-bs-toggle="modal" data-bs-target="#addMedicalRecordModal">
                                        Add Medical Record
                                    </button>
                                </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered whitespace-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Vet</th>
                                                <th>Diagnosis</th>
                                                <th>Treatment</th>
                                                @if(in_array(auth()->user()->role, ['vet', 'staff', 'admin']))
                                                <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pet->medicalRecords as $record)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($record->visit_date)->format('d M Y') }}</td>
                                                    <td>{{ $record->vet->name }}</td>
                                                    <td>{{ $record->diagnosis }}</td>
                                                    <td>{{ $record->treatment }}</td>
                                                    @if(in_array(auth()->user()->role, ['vet', 'staff', 'admin']))
                                                    <td>
                                                        <form action="{{ route('medical-records.destroy', $record->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-danger" onclick="return confirm('Delete this record?')">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr><td colspan="5" class="text-center">No medical records found.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- Vaccinations --}}
                            <div class="tab-pane" id="vaccinations" role="tabpanel">
                                @if(in_array(auth()->user()->role, ['vet', 'staff', 'admin']))
                                <div class="mb-3 text-end">
                                    <button class="ti-btn ti-btn-primary-full ti-btn-wave" data-bs-toggle="modal" data-bs-target="#addVaccinationModal">
                                        Add Vaccination
                                    </button>
                                </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered whitespace-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Vaccine</th>
                                                <th>Date Given</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                @if(in_array(auth()->user()->role, ['vet', 'staff', 'admin']))
                                                <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pet->vaccinationRecords as $vax)
                                                <tr>
                                                    <td>{{ $vax->vaccine_name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($vax->administered_date)->format('d M Y') }}</td>
                                                    <td>{{ $vax->due_date ? \Carbon\Carbon::parse($vax->due_date)->format('d M Y') : '-' }}</td>
                                                    <td>
                                                        <span class="badge {{ $vax->status == 'given' ? 'bg-success/10 text-success' : 'bg-warning/10 text-warning' }}">
                                                            {{ ucfirst($vax->status) }}
                                                        </span>
                                                    </td>
                                                    @if(in_array(auth()->user()->role, ['vet', 'staff', 'admin']))
                                                    <td>
                                                        <form action="{{ route('vaccination-records.destroy', $vax->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-danger" onclick="return confirm('Delete this vaccination record?')">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr><td colspan="5" class="text-center">No vaccination records found.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- Appointments --}}
                            <div class="tab-pane" id="appointments" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered whitespace-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Date/Time</th>
                                                <th>Service</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pet->appointments as $appointment)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }} {{ $appointment->appointment_time }}</td>
                                                    <td>{{ $appointment->service_type }}</td>
                                                    <td>
                                                        <span class="badge {{ $appointment->status == 'confirmed' ? 'bg-success/10 text-success' : 'bg-info/10 text-info' }}">
                                                            {{ ucfirst($appointment->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="3" class="text-center">No appointments found.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @if(in_array(auth()->user()->role, ['vet', 'staff', 'admin']))
    <!-- Add Medical Record Modal -->
    <div class="modal fade" id="addMedicalRecordModal" tabindex="-1" aria-labelledby="addMedicalRecordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addMedicalRecordModalLabel">Add Medical Record</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('medical-records.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                    <input type="hidden" name="vet_id" value="{{ auth()->id() }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Visit Date</label>
                            <input type="date" name="visit_date" class="form-control" required value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Diagnosis</label>
                            <textarea name="diagnosis" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Treatment</label>
                            <textarea name="treatment" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prescription</label>
                            <textarea name="prescription" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="ti-btn ti-btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="ti-btn ti-btn-primary">Save Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Vaccination Modal -->
    <div class="modal fade" id="addVaccinationModal" tabindex="-1" aria-labelledby="addVaccinationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addVaccinationModalLabel">Add Vaccination Record</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('vaccination-records.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Vaccine Name</label>
                            <input type="text" name="vaccine_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date Given</label>
                            <input type="date" name="administered_date" class="form-control" required value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Next Due Date (Optional)</label>
                            <input type="date" name="due_date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="given">Given</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="ti-btn ti-btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="ti-btn ti-btn-primary">Save Vaccination</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection
