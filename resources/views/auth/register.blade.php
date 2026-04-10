<x-guest-layout>
    <div class="mb-5 text-center">
        <h4 style="font-size:1.25rem; font-weight:700; color:#111827; margin-bottom:0.25rem;">Sign Up</h4>
        <p style="font-size:0.875rem; color:#6b7280;">Join VetConnect today!</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="display:flex; flex-direction:column; gap:1rem;">
            <!-- Name -->
            <div>
                <label for="name" style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:0.35rem;">Full Name</label>
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name" style="width:100%; background:#fff; color:#111827; border:1px solid #d1d5db;">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:0.35rem;">Email Address</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email" style="width:100%; background:#fff; color:#111827; border:1px solid #d1d5db;">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:0.35rem;">Password</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Enter a secure password" style="width:100%; background:#fff; color:#111827; border:1px solid #d1d5db;">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:0.35rem;">Confirm Password</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" style="width:100%; background:#fff; color:#111827; border:1px solid #d1d5db;">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div style="margin-top:0.5rem;">
                <button type="submit" class="ti-btn ti-btn-primary-full" style="width:100%;">
                    Create Account &nbsp;<i class="fe fe-user-plus"></i>
                </button>
            </div>
        </div>
    </form>

    <div style="text-align:center; margin-top:1rem;">
        <p style="font-size:0.8125rem; color:#6b7280; margin:0;">
            Already have an account? 
            <a href="{{ route('login') }}" style="color:#6366f1; font-weight:600; text-decoration:none;">Log In</a>
        </p>
    </div>
</x-guest-layout>
