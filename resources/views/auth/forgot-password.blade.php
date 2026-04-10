<x-guest-layout>
    <div class="mb-5 text-center">
        <h4 class="font-semibold text-xl text-defaulttextcolor dark:text-defaulttextcolor/70 mb-1">Forgot Password</h4>
        <p class="text-textmuted text-[0.85rem]">We will email you a password reset link.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="grid grid-cols-12 gap-y-4">
            <!-- Email Address -->
            <div class="col-span-12">
                <label for="email" class="form-label text-defaulttextcolor font-semibold">Email Address</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email address">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger text-sm" />
            </div>

            <div class="col-span-12 mt-2">
                <button type="submit" class="ti-btn ti-btn-primary-full w-full">
                    Email Password Reset Link <i class="fe fe-mail ms-2"></i>
                </button>
            </div>
        </div>
    </form>
    
    <div class="text-center mt-4">
        <p class="text-textmuted text-[0.8125rem] mb-0">Remembered your password? <a href="{{ route('login') }}" class="text-primary font-semibold">Log In</a></p>
    </div>
</x-guest-layout>
