@extends('layouts.valex')
@section('page-title', 'Global Search Results')
@section('breadcrumb-parent', 'Dashboard')
@section('breadcrumb-child', 'Search')

@section('content')
    <div class="xl:col-span-12 col-span-12 mt-3">
        <div class="box custom-box">
            <div class="box-header">
                <div class="box-title">
                    Search Results for: <span class="text-primary">"{{ $query }}"</span>
                </div>
            </div>
            <div class="box-body">
                {{-- Pets Section --}}
                <div class="mb-5">
                    <h5 class="text-[0.875rem] font-semibold mb-3 flex items-center gap-2">
                        <i class="fa fa-paw text-primary"></i> Pets ({{ $pets->count() }})
                    </h5>
                    @if($pets->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table whitespace-nowrap table-bordered min-w-full">
                                <thead>
                                    <tr class="border-b border-defaultborder">
                                        <th scope="col" class="text-start">Name</th>
                                        <th scope="col" class="text-start">Owner</th>
                                        <th scope="col" class="text-start">Species/Breed</th>
                                        <th scope="col" class="text-start">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pets as $pet)
                                        <tr class="border-b border-defaultborder">
                                            <td><a href="{{ route('pets.show', $pet->id) }}" class="text-primary font-medium">{{ $pet->name }}</a></td>
                                            <td>{{ $pet->owner->name }}</td>
                                            <td>{{ $pet->species }} ({{ $pet->breed ?? 'Unknown' }})</td>
                                            <td>
                                                <a href="{{ route('pets.show', $pet->id) }}" class="ti-btn ti-btn-sm ti-btn-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-textmuted text-sm italic">No pets found matching your query.</p>
                    @endif
                </div>

                {{-- Owners Section (Admin/Staff only) --}}
                @if(auth()->user()->role !== 'owner')
                    <div>
                        <h5 class="text-[0.875rem] font-semibold mb-3 flex items-center gap-2">
                            <i class="fa fa-user text-secondary"></i> Owners/Users ({{ $owners->count() }})
                        </h5>
                        @if($owners->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table whitespace-nowrap table-bordered min-w-full">
                                    <thead>
                                        <tr class="border-b border-defaultborder">
                                            <th scope="col" class="text-start">Name</th>
                                            <th scope="col" class="text-start">Email</th>
                                            <th scope="col" class="text-start">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($owners as $owner)
                                            <tr class="border-b border-defaultborder">
                                                <td>{{ $owner->name }}</td>
                                                <td>{{ $owner->email }}</td>
                                                <td>
                                                    <a href="{{ route('users.edit', $owner->id) }}" class="ti-btn ti-btn-sm ti-btn-secondary">Edit User</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-textmuted text-sm italic">No owners found matching your query.</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
