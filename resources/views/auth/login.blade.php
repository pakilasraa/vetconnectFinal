<x-guest-layout>
    <div class="mb-5 text-center">
        <h4 class="font-semibold text-xl text-defaulttextcolor dark:text-defaulttextcolor/70 mb-1">Sign In</h4>
        <p class="text-textmuted text-[0.85rem]">Welcome back to VetConnect!</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="grid grid-cols-12 gap-y-4">
            <!-- Email Address -->
            <div class="col-span-12">
                <label for="email" class="form-label text-defaulttextcolor font-semibold">Email Address</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger text-sm" />
            </div>

            <!-- Password -->
            <div class="col-span-12">
                <div class="flex justify-between">
                    <label for="password" class="form-label text-defaulttextcolor font-semibold">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[0.75rem] text-textmuted hover:text-primary font-medium">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger text-sm" />
            </div>

            <!-- Remember Me -->
            <div class="col-span-12">
                <div class="form-check !ps-0 flex items-center">
                    <input class="form-check-input !border-gray-300 dark:!border-gray-600 rounded !mt-0 !me-2" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label text-[#8c9097] text-[0.8125rem] font-normal" for="remember_me">
                        Remember me
                    </label>
                </div>
            </div>

            <div class="col-span-12 mt-2">
                <button type="submit" class="ti-btn ti-btn-primary-full w-full">
                    Log In <i class="fe fe-log-in ms-2"></i>
                </button>
            </div>
        </div>
    </form>
    <div class="text-center mt-4">
        <p class="text-textmuted text-[0.8125rem] mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary font-semibold">Sign Up</a></p>
    </div>
</x-guest-layout>
