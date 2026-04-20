@extends('layouts.valex')

@section('page-title', 'Edit User')
@section('breadcrumb-parent', 'User Management')
@section('breadcrumb-child', 'Edit')

@section('content')
    <div class="xl:col-span-6 col-span-12">

    <!-- Start:: row-1 -->
    <div class="grid grid-cols-12 gap-6 text-defaultsize">
        <div class="xl:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header flex justify-between">
                    <div class="box-title">
                        Input Types
                    </div>

                </div>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="box-body">
                    <div class="grid grid-cols-12 sm:gap-6">

                        {{-- Full Name --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                            <label for="input-fullname" class="form-label !font-normal">Full Name:</label>
                            <input type="text" name="name" class="form-control" id="input-fullname" value="{{ $user->name }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                            <label for="input-email" class="form-label !mb-2">Email</label>
                            <input type="email" name="email" class="form-control" id="input-email" value="{{ $user->email }}" required>
                        </div>

                        {{-- Password --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                            <label for="input-password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control placeholder:text-textmuted" id="input-password"
                                placeholder="Leave blank to keep current password">
                        </div>

                        {{-- Birthdate --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                            <label for="input-date" class="form-label">Birthdate</label>
                            <input type="date" name="birthdate" class="form-control" id="input-date" value="{{ $user->birthdate }}">
                        </div>

                        {{-- Role --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                            <label for="input-role" class="form-label">Role</label>
                            <select name="role" id="input-role" class="form-control" required>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="pet_owner" {{ in_array($user->role, ['pet_owner', 'owner'], true) ? 'selected' : '' }}>Pet owner</option>
                            </select>
                        </div>

                        {{-- Upload --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                            <label for="file-input" class="form-label">Upload Profile Photo</label>
                            <input type="file" name="photo" id="file-input"
                                class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10
                                            file:border-0
                                           file:bg-gray-200 file:me-4
                                           file:py-3 file:px-4
                                           dark:file:bg-black/20 dark:file:text-white/50">
                        </div>

                        {{-- Submit Button --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12 flex items-end">
                            <div class="ti-btn-list w-full">
                                <button type="submit"
                                    class="ti-btn ti-btn-primary-full !rounded-full ti-btn-wave w-full">Update User</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    </div>
    <!-- End:: row-1 -->
@endsection
