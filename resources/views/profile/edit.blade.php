@extends('layouts.valex')

@section('page-title', 'Profile Settings')
@section('breadcrumb-parent', 'Settings')
@section('breadcrumb-child', 'Profile')

@section('content')
    <div class="grid grid-cols-12 gap-x-6">
        <div class="xl:col-span-12 col-span-12">
            <div class="box custom-box">
                <div class="box-header">
                    <div class="box-title">
                        Profile Management
                    </div>
                </div>
                <div class="box-body">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <hr class="my-6 border-defaultborder dark:border-defaultborder/10">

                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>

                    <hr class="my-6 border-defaultborder dark:border-defaultborder/10">

                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
