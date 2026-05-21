<x-guest-layout>
    <div class="row g-0">
        <div class="col-md-4 auth-side d-flex flex-column justify-content-center p-4">
            <div>
                <h3>New here?</h3>
                <p>Join Crypto Marketplace to start tracking assets, managing trades, and exploring market trends.</p>
            </div>

            <div class="mt-auto">
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg w-100">Already have an account?</a>
            </div>
        </div>

        <div class="col-md-8 auth-form">
            <h2>Register</h2>
            <p>Create your secure account to join the crypto marketplace.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" :class="$errors->get('name') ? 'is-invalid' : ''" required
                        autofocus autocomplete="name" class="form-control" />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" :class="$errors->get('email') ? 'is-invalid' : ''" required
                        autocomplete="username" class="form-control" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" :class="$errors->get('password') ? 'is-invalid' : ''" required
                        autocomplete="new-password" class="form-control" />
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <div class="mb-3">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" :class="$errors->get('password_confirmation') ? 'is-invalid' : ''"
                        required autocomplete="new-password" class="form-control" />
                    <x-input-error :messages="$errors->get('password_confirmation')" />
                </div>

                <div class="d-grid mb-3">
                    <x-primary-button class="btn btn-primary btn-lg">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

            @if (config('services.google.client_id'))
                <div class="mt-3">
                    <a href="{{ route('auth.google.redirect') }}" class="btn btn-google w-100 d-flex align-items-center justify-content-center gap-2">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo" width="20" height="20">
                        {{ __('Continue with Google') }}
                    </a>
                </div>
            @endif

            <p class="auth-footer mt-4">Already registered? Use the button on the left to sign in.</p>
        </div>
    </div>
</x-guest-layout>
