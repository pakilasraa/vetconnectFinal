<x-guest-layout>
    <div class="mb-5 text-center">
        <h4 class="font-semibold text-xl text-defaulttextcolor dark:text-defaulttextcolor/70 mb-1">Sign Up</h4>
        <p class="text-textmuted text-[0.85rem]">Join VetConnect today!</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="grid grid-cols-12 gap-y-4">
            <!-- Name -->
            <div class="col-span-12">
                <label for="name" class="form-label text-defaulttextcolor font-semibold">Full Name</label>
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name">
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger text-sm" />
            </div>

            <!-- Email Address -->
            <div class="col-span-12">
                <label for="email" class="form-label text-defaulttextcolor font-semibold">Email Address</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger text-sm" />
            </div>

            <!-- Password -->
            <div class="col-span-12">
                <label for="password" class="form-label text-defaulttextcolor font-semibold">Password</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Enter a secure password">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger text-sm" />
            </div>

            <!-- Confirm Password -->
            <div class="col-span-12">
                <label for="password_confirmation" class="form-label text-defaulttextcolor font-semibold">Confirm Password</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger text-sm" />
            </div>
            
            <div class="col-span-12 mt-2">
                <button type="submit" class="ti-btn ti-btn-primary-full w-full">
                    Create Account <i class="fe fe-user-plus ms-2"></i>
                </button>
            </div>
        </div>
    </form>
    <div class="text-center mt-4">
        <p class="text-textmuted text-[0.8125rem] mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary font-semibold">Log In</a></p>
    </div>
</x-guest-layout>
