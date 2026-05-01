@extends('layouts.client-app')

@section('title', 'Profile Settings - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Profile Settings</h1>
        <p class="page-subtitle">Manage your account details and security.</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Profile Information</h2>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="form">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label class="form-label" for="photo">Profile Photo</label>
                <div class="client-profile-photo-preview">
                    <img src="{{ $user->photo_url }}" alt="Current profile photo" id="clientProfilePreviewImage">
                    <p class="text-muted">Current photo</p>
                </div>
                <input id="photo" name="photo" type="file" accept="image/*" class="form-control">
                @error('photo') <p class="text-danger mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label" for="name">Name</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autocomplete="name">
                    @error('name') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Profile</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Update Password</h2>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}" class="form">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label" for="current_password">Current Password</label>
                    <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
                    @if ($errors->updatePassword->get('current_password'))
                        <p class="text-danger mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">New Password</label>
                    <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
                    @if ($errors->updatePassword->get('password'))
                        <p class="text-danger mt-1">{{ $errors->updatePassword->first('password') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Password</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Delete Account</h2>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('profile.destroy') }}" class="form" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.')">
            @csrf
            @method('DELETE')

            <div class="form-group">
                <label class="form-label" for="delete_password">Confirm Password</label>
                <input id="delete_password" name="password" type="password" class="form-control" autocomplete="current-password" required>
                @if ($errors->userDeletion->get('password'))
                    <p class="text-danger mt-1">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Delete My Account</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const fileInput = document.getElementById('photo');
        const previewImage = document.getElementById('clientProfilePreviewImage');
        if (!fileInput || !previewImage) return;

        fileInput.addEventListener('change', function () {
            const file = fileInput.files && fileInput.files[0] ? fileInput.files[0] : null;
            if (!file) return;
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                if (event.target && typeof event.target.result === 'string') {
                    previewImage.src = event.target.result;
                }
            };
            reader.readAsDataURL(file);
        });
    })();
</script>
@endpush
