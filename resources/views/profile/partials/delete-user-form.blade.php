<section class="space-y-6">
    <header>
        <h2 class="text-[0.9375rem] font-medium text-defaulttextcolor">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-[0.75rem] text-textmuted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        class="ti-btn ti-btn-danger-full ti-btn-wave"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-[0.9375rem] font-medium text-defaulttextcolor">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-[0.875rem] text-textmuted">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                @if ($errors->userDeletion->get('password'))
                    <ul class="text-sm text-danger mt-2">
                        @foreach ($errors->userDeletion->get('password') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <button type="button" class="ti-btn ti-btn-secondary-full ti-btn-wave" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="ti-btn ti-btn-danger-full ti-btn-wave">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
