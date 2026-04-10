@extends('layouts.valex')

@section('page-title', 'Create User')
@section('breadcrumb-parent', 'User Management')
@section('breadcrumb-child', 'Create')

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

                <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="box-body">
                    <div class="grid grid-cols-12 sm:gap-6">

                        {{-- Full Name --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                            <label for="input-fullname" class="form-label !font-normal">Full Name:</label>
                            <input type="text" name="name" class="form-control" id="input-fullname" required>
                        </div>

                        {{-- Email --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                            <label for="input-email" class="form-label !mb-2">Email</label>
                            <input type="email" name="email" class="form-control" id="input-email" required>
                        </div>

                        {{-- Password --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                            <label for="input-password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control placeholder:text-textmuted" id="input-password"
                                placeholder="Enter password" required>
                        </div>

                        {{-- Birthdate --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                            <label for="input-date" class="form-label">Birthdate</label>
                            <input type="date" name="birthdate" class="form-control" id="input-date">
                        </div>

                        {{-- Role --}}
                        <div class="xl:col-span-4 lf:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                            <label for="input-role" class="form-label">Role</label>
                            <select name="role" id="input-role" class="form-control" required>
                                <option value="" disabled selected>Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                                <option value="vet">Vet</option>
                                <option value="owner">Owner</option>
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
                                    class="ti-btn ti-btn-primary-full !rounded-full ti-btn-wave w-full">Submit</button>
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
