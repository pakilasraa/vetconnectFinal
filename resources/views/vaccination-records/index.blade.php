@extends('layouts.valex')
@section('page-title', 'Vaccination Records')
@section('breadcrumb-parent', 'Medical Records')
@section('breadcrumb-child', 'Vaccinations')

@section('content')
    <div class="xl:col-span-12 col-span-12">
        <div class="box custom-box mt-3">
            <div class="box-header flex justify-between">
                <div class="box-title">
                    Vaccination History
                </div>
                @if(auth()->user()->role !== 'owner')
                <div class="flex items-center gap-2">
                    <a href="{{ route('vaccination-records.create') }}" class="ti-btn !py-1 !px-2 ti-btn-primary !font-medium !text-[0.75rem]">
                        New Vaccination<i class="ri-add-circle-line ms-2 inline-block align-middle"></i>
                    </a>
                </div>
                @endif
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table whitespace-nowrap table-bordered min-w-full">
                        <thead>
                            <tr class="border-b border-defaultborder">
                                <th scope="col" class="text-start">Date Given</th>
                                <th scope="col" class="text-start">Pet Name</th>
                                <th scope="col" class="text-start">Vaccine</th>
                                <th scope="col" class="text-start">Next Dose (Due)</th>
                                <th scope="col" class="text-start">Status</th>
                                <th scope="col" class="text-start">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($records as $record)
                                <tr class="border-b border-defaultborder">
                                    <td>{{ \Carbon\Carbon::parse($record->administered_date)->format('M d, Y') }}</td>
                                    <td><a href="{{ route('pets.show', $record->pet_id) }}" class="text-primary font-medium">{{ $record->pet->name }}</a></td>
                                    <td>{{ $record->vaccine_name }}</td>
                                    <td>{{ $record->due_date ? \Carbon\Carbon::parse($record->due_date)->format('M d, Y') : 'N/A' }}</td>
                                    <td>
                                        @if($record->status === 'given')
                                            <span class="badge bg-success/10 text-success">Given</span>
                                        @else
                                            <span class="badge bg-warning/10 text-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            @if(auth()->user()->role !== 'owner')
                                            <a href="{{ route('vaccination-records.edit', $record->id) }}"
                                                class="text-info text-[.875rem] leading-none">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ route('vaccination-records.destroy', $record->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger text-[.875rem] leading-none" onclick="return confirm('Are you sure you want to delete this record?')">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </form>
                                            @else
                                            <span class="text-textmuted text-xs">View Only</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-textmuted">No vaccination records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
