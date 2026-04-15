@extends('layouts.app')

@section('title', 'Profile - VetConnect')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Profile Settings</h1>
        <p class="page-subtitle">Manage your account information and preferences</p>
    </div>
</div>

<!-- Profile Header -->
<div class="card">
    <div class="profile-header">
        <div class="profile-avatar">
            {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
        </div>
        <div class="profile-info">
            <h2 class="profile-name">{{ $user->full_name }}</h2>
            <p class="profile-email">{{ $user->email }}</p>
            <p class="profile-meta">📅 Member since {{ $user->created_at->format('F Y') }}</p>
        </div>
    </div>
</div>

<!-- Tabs -->
<div class="tabs">
    <a href="#personal" class="tab active" onclick="showTab('personal'); return false;">Personal Information</a>
    <a href="#notifications" class="tab" onclick="showTab('notifications'); return false;">Notifications</a>
    <a href="#security" class="tab" onclick="showTab('security'); return false;">Security</a>
</div>

<!-- Personal Information Tab -->
<div id="personal-tab" class="tab-content active">
    <div class="card">
        <form action="{{ route('profile.update') }}" method="POST" class="form">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="first_name" class="form-label">👤 First Name</label>
                    <input type="text" id="first_name" name="first_name"
                           value="{{ old('first_name', $user->first_name) }}"
                           class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="last_name" class="form-label">👤 Last Name</label>
                    <input type="text" id="last_name" name="last_name"
                           value="{{ old('last_name', $user->last_name) }}"
                           class="form-input" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">📧 Email Address</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       class="form-input" required>
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">📞 Phone Number</label>
                <input type="tel" id="phone" name="phone"
                       value="{{ old('phone', $user->phone) }}"
                       class="form-input">
            </div>

            <div class="form-group">
                <label for="address" class="form-label">📍 Address</label>
                <input type="text" id="address" name="address"
                       value="{{ old('address', $user->address) }}"
                       class="form-input">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Notifications Tab -->
<div id="notifications-tab" class="tab-content">
    <div class="card">
        <form action="{{ route('profile.notifications.update') }}" method="POST" class="form">
            @csrf
            @method('PUT')

            <div class="notification-item">
                <div class="notification-info">
                    <h3 class="notification-title">🔔 Appointment Reminders</h3>
                    <p class="notification-desc">Get notified about upcoming appointments</p>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="appointment_reminders"
                           {{ $user->appointment_reminders ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>

            <div class="notification-item">
                <div class="notification-info">
                    <h3 class="notification-title">🔔 Vaccination Alerts</h3>
                    <p class="notification-desc">Reminders for upcoming vaccinations</p>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="vaccination_alerts"
                           {{ $user->vaccination_alerts ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>

            <div class="notification-item">
                <div class="notification-info">
                    <h3 class="notification-title">📧 Promotional Emails</h3>
                    <p class="notification-desc">Receive updates about special offers and news</p>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="promotional_emails"
                           {{ $user->promotional_emails ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>

            <div class="notification-item">
                <div class="notification-info">
                    <h3 class="notification-title">📱 SMS Notifications</h3>
                    <p class="notification-desc">Receive text messages for important updates</p>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="sms_notifications"
                           {{ $user->sms_notifications ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Save Preferences</button>
            </div>
        </form>
    </div>
</div>

<!-- Security Tab -->
<div id="security-tab" class="tab-content">
    <div class="card">
        <div class="security-section">
            <h3 class="security-title">🔒 Change Password</h3>
            <p class="security-desc">Update your password to keep your account secure</p>
            <button class="btn btn-primary" onclick="document.getElementById('password-form').style.display='block'">Change Password</button>

            <form id="password-form" action="{{ route('profile.password.update') }}" method="POST" class="form" style="display: none; margin-top: 1rem;">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-input" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="security-section">
            <h3 class="security-title">💳 Payment Methods</h3>
            <p class="security-desc">Manage your payment methods for appointments</p>
            <button class="btn btn-outline">Manage Payment Methods</button>
        </div>
    </div>

    <div class="card card-danger">
        <div class="security-section">
            <h3 class="security-title">⚠️ Delete Account</h3>
            <p class="security-desc">Permanently delete your account and all associated data</p>
            <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Account</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showTab(tabName) {
    // Hide all tab contents
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => content.classList.remove('active'));

    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => tab.classList.remove('active'));

    // Show selected tab content
    document.getElementById(tabName + '-tab').classList.add('active');

    // Add active class to clicked tab
    event.target.classList.add('active');
}
</script>
@endpush
