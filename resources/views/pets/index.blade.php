@extends('layouts.valex')
@section('page-title', 'Pet Management')
@section('breadcrumb-parent', 'Patient Records')
@section('breadcrumb-child', 'Index')

@section('content')

    <div class="xl:col-span-12 col-span-12">

        <div class="box custom-box mt-3">
            <div class="box-header flex justify-between">
                <div class="box-title">
                    Pets List
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ panel_route('pets.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search pets..." value="{{ request('search') }}">
                        <button type="submit" class="ti-btn ti-btn-primary !py-1 !px-2 ms-2"><i class="ri-search-line"></i></button>
                    </form>
                    <a href="{{ panel_route('pets.create') }}" class="ti-btn !py-1 !px-2 ti-btn-primary !font-medium !text-[0.75rem]">New
                        Pet<i class="ri-add-circle-line ms-2 inline-block align-middle"></i></a>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table whitespace-nowrap table-bordered min-w-full">
                        <thead>
                            <tr class="border-b border-defaultborder">
                                <th scope="col" class="text-start">ID</th>
                                <th scope="col" class="text-start">Pet Name</th>
                                <th scope="col" class="text-start">Owner</th>
                                <th scope="col" class="text-start">Species</th>
                                <th scope="col" class="text-start">Breed</th>
                                <th scope="col" class="text-start">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pets as $pet)
                                <tr class="border-b border-defaultborder">
                                    <td>{{ $pet->id }}</td>
                                    <td><a href="{{ panel_route('pets.show', $pet->id) }}" class="text-primary font-medium">{{ $pet->name }}</a></td>
                                    <td>{{ $pet->owner->name }}</td>
                                    <td>{{ $pet->species }}</td>
                                    <td>{{ $pet->breed }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ panel_route('pets.show', $pet->id) }}"
                                                class="text-primary text-[.875rem] leading-none">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ panel_route('pets.edit', $pet->id) }}"
                                                class="text-info text-[.875rem] leading-none">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ panel_route('pets.destroy', $pet->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger text-[.875rem] leading-none" onclick="return confirm('Are you sure you want to delete this pet record?')">
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
                    {{ $pets->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
