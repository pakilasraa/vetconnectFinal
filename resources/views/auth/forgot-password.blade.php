<x-guest-layout>
    <div class="mb-5 text-center">
        <h4 style="font-size:1.25rem; font-weight:700; color:#111827; margin-bottom:0.25rem;">Forgot Password</h4>
        <p style="font-size:0.875rem; color:#6b7280;">We will send a reset link to your email.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div style="display:flex; flex-direction:column; gap:1rem;">
            <div>
                <label for="email" style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:0.35rem;">Email Address</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email address" style="width:100%; background:#fff; color:#111827; border:1px solid #d1d5db;">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div style="margin-top:0.5rem;">
                <button type="submit" class="ti-btn ti-btn-primary-full" style="width:100%;">
                    Email Password Reset Link &nbsp;<i class="fe fe-mail"></i>
                </button>
            </div>
        </div>
    </form>

    <div style="text-align:center; margin-top:1rem;">
        <p style="font-size:0.8125rem; color:#6b7280; margin:0;">
            Remembered your password? 
            <a href="{{ route('login') }}" style="color:#6366f1; font-weight:600; text-decoration:none;">Log In</a>
        </p>
    </div>
</x-guest-layout>
