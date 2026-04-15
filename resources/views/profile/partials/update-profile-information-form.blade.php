<section>
    <header>
        <h2 class="text-[0.9375rem] font-medium text-defaulttextcolor">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-[0.75rem] text-textmuted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mb-4">
            <label class="form-label">{{ __('Profile Photo') }}</label>
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 rounded-full overflow-hidden border border-defaultborder bg-white">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('backend/assets/images/faces/9.jpg') }}" alt="Profile Photo" class="h-full w-full object-cover">
                </div>
                <div class="flex-1">
                    <input id="photo" name="photo" type="file" accept="image/*" class="form-control" />
                    @if ($errors->get('photo'))
                        <ul class="text-sm text-danger mt-2">
                            @foreach ($errors->get('photo') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="mt-3">
                        <button type="submit" class="ti-btn ti-btn-secondary ti-btn-wave">{{ __('Save Photo') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @if ($errors->get('name'))
                <ul class="text-sm text-danger mt-2">
                    @foreach ($errors->get('name') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="mb-4">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @if ($errors->get('email'))
                <ul class="text-sm text-danger mt-2">
                    @foreach ($errors->get('email') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-defaulttextcolor">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="ti-btn ti-btn-link text-primary underline">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="ti-btn ti-btn-primary-full ti-btn-wave">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-[0.75rem] text-textmuted"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
