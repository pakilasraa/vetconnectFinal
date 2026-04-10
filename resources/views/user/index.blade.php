@extends('layouts.valex')
@section('page-title', 'Users Management')
@section('breadcrumb-parent', 'User Management')
@section('breadcrumb-child', 'Index')

@section('content')

    <div class="xl:col-span-6 col-span-12">

        <div class="box custom-box">

            <div class="box-header flex justify-between">
                <div class="box-title">
                    Users List
                </div>
                <div class="prism-toggle">
                    <a href="{{ route('users.create') }}" class="ti-btn !py-1 !px-2 ti-btn-primary !font-medium !text-[0.75rem]">New
                        User<i class="ri-add-circle-line ms-2 inline-block align-middle"></i></a>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table whitespace-nowrap table-bordered min-w-full">
                        <thead>
                            <tr class="border-b border-defaultborder">
                                <th scope="col" class="text-start">ID</th>
                                <th scope="col" class="text-start">Name</th>
                                <th scope="col" class="text-start">Email</th>
                                <th scope="col" class="text-start">Status</th>
                                <th scope="col" class="text-start">Date Registered</th>
                                <th scope="col" class="text-start">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b border-defaultborder">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    
                                    
                                    <td>
                                        @if($user->status == 1)
                                            <span class="badge bg-success/10 text-success">Active</span>
                                        @else
                                            <span class="badge bg-danger/10 text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y h:i A') }}</td>
                                    <td>

                                        
                                    
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="text-info text-[.875rem] leading-none">
                                                <i class="ri-edit-line"></i>
                                            </a>
                            
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger text-[.875rem] leading-none" onclick="return confirm('Are you sure you want to delete this user?')">
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
            </div>
        </div>
    </div>
@endsection
