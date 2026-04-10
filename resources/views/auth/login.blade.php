<x-guest-layout>
    <div class="mb-5 text-center">
        <h4 style="font-size:1.25rem; font-weight:700; color:#111827; margin-bottom:0.25rem;">Sign In</h4>
        <p style="font-size:0.875rem; color:#000000;">Welcome back to VetConnect!</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="display:flex; flex-direction:column; gap:1rem;">
            <!-- Email Address -->
            <div>
                <label for="email" style="display:block; font-size:0.875rem; font-weight:600; color:#000000; margin-bottom:0.35rem;">Email Address</label>
                <input 
                    id="email" 
                    class="form-control" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required autofocus autocomplete="username" 
                    placeholder="Enter your email"
                    style="width:100%; background:#fff; color:#111827; border:1px solid #d1d5db;"
                >
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.35rem;">
                    <label for="password" style="font-size:0.875rem; font-weight:600; color:#000000;">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:0.75rem; color:#6366f1; font-weight:500; text-decoration:none;">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <input 
                    id="password" 
                    class="form-control"
                    type="password" 
                    name="password" 
                    required autocomplete="current-password" 
                    placeholder="Enter your password"
                    style="width:100%; background:#fff; color:#111827; border:1px solid #d1d5db;"
                >
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div style="display:flex; align-items:center; gap:0.5rem;">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember" style="margin:0;">
                <label for="remember_me" style="font-size:0.8125rem; color:#000000; margin:0; cursor:pointer;">Remember me</label>
            </div>

            <div style="margin-top:0.5rem;">
                <button type="submit" class="ti-btn ti-btn-primary-full" style="width:100%;">
                    Log In &nbsp;<i class="fe fe-log-in"></i>
                </button>
            </div>
        </div>
    </form>

    <div style="text-align:center; margin-top:1rem;">
        <p style="font-size:0.8125rem; color:#000000; margin:0;">
            Don't have an account? 
            <a href="{{ route('register') }}" style="color:#6366f1; font-weight:600; text-decoration:none;">Sign Up</a>
        </p>
    </div>
</x-guest-layout>
