@extends('layouts.valex')
@section('page-title', 'Appointment Management')
@section('breadcrumb-parent', 'Appointment Management')
@section('breadcrumb-child', 'Index')

@section('content')

    <div class="xl:col-span-12 col-span-12">

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="box custom-box mt-3">
            <div class="box-header flex justify-between">
                <div class="box-title">
                    Upcoming Appointments
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ panel_route('appointments.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search appointments..." value="{{ request('search') }}">
                        <button type="submit" class="ti-btn ti-btn-primary !py-1 !px-2 ms-2"><i class="ri-search-line"></i></button>
                    </form>
                    <a href="{{ panel_route('appointments.create') }}" class="ti-btn !py-1 !px-2 ti-btn-primary !font-medium !text-[0.75rem]">New
                        Appointment<i class="ri-add-circle-line ms-2 inline-block align-middle"></i></a>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table whitespace-nowrap table-bordered min-w-full">
                        <thead>
                            <tr class="border-b border-defaultborder">
                                <th scope="col" class="text-start">ID</th>
                                <th scope="col" class="text-start">Pet</th>
                                <th scope="col" class="text-start">Owner</th>
                                <th scope="col" class="text-start">Date</th>
                                <th scope="col" class="text-start">Time</th>
                                <th scope="col" class="text-start">Service</th>
                                <th scope="col" class="text-start">Status</th>
                                <th scope="col" class="text-start">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr class="border-b border-defaultborder">
                                    <td>{{ $appointment->id }}</td>
                                    <td>{{ $appointment->pet->name }}</td>
                                    <td>{{ $appointment->owner->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                    <td>{{ $appointment->service_type }}</td>
                                    <td>
                                        <span class="badge {{ $appointment->status == 'confirmed' ? 'bg-success/10 text-success' : ($appointment->status == 'cancelled' ? 'bg-danger/10 text-danger' : 'bg-info/10 text-info') }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ panel_route('appointments.edit', $appointment->id) }}"
                                                class="text-info text-[.875rem] leading-none">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ panel_route('appointments.destroy', $appointment->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger text-[.875rem] leading-none" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $appointments->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
