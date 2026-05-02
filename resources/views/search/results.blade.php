@extends('layouts.valex')
@section('page-title', 'Global Search Results')

@section('styles')
    <style>
        .search-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.28rem 0.72rem;
            border-radius: 0.45rem;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.15;
            border: 1px solid transparent;
            white-space: nowrap;
            transition: background-color 0.18s ease, color 0.18s ease, border-color 0.18s ease;
        }

        .search-action-btn--primary {
            color: rgb(var(--primary-rgb, 98, 89, 202));
            border-color: rgba(var(--primary-rgb, 98, 89, 202), 0.28);
            background-color: rgba(var(--primary-rgb, 98, 89, 202), 0.08);
        }

        .search-action-btn--primary:hover {
            color: #fff;
            border-color: rgb(var(--primary-rgb, 98, 89, 202));
            background-color: rgb(var(--primary-rgb, 98, 89, 202));
        }

        .search-action-btn--secondary {
            color: rgb(var(--secondary-rgb, 8, 59, 130));
            border-color: rgba(var(--secondary-rgb, 8, 59, 130), 0.28);
            background-color: rgba(var(--secondary-rgb, 8, 59, 130), 0.08);
        }

        .search-action-btn--secondary:hover {
            color: #fff;
            border-color: rgb(var(--secondary-rgb, 8, 59, 130));
            background-color: rgb(var(--secondary-rgb, 8, 59, 130));
        }
    </style>
@endsection

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
                                            <td><a href="{{ route('admin.pets.show', $pet->id) }}" class="text-primary font-medium">{{ $pet->name }}</a></td>
                                            <td>{{ $pet->owner->name }}</td>
                                            <td>{{ $pet->species }} ({{ $pet->breed ?? 'Unknown' }})</td>
                                            <td>
                                                <a href="{{ route('admin.pets.show', $pet->id) }}" class="search-action-btn search-action-btn--primary">View</a>
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
                @if(auth()->user()->isAdmin())
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
                                                    <a href="{{ route('admin.users.edit', $owner->id) }}" class="search-action-btn search-action-btn--secondary">Edit User</a>
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
