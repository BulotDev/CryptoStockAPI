<x-guest-layout>
    <div class="row g-0">
        <div class="col-md-4 auth-side d-flex flex-column justify-content-center p-4">
            <div>
                <h3>Welcome back</h3>
                <p>Sign in to access your Crypto Marketplace Dashboard.</p>
            </div>

            <div class="mt-auto">
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg w-100">Create an account</a>
            </div>
        </div>

        <div class="col-md-8 auth-form">
            <h2>Login</h2>
            <p>Use your email or continue with Google to sign in.</p>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" :class="$errors->get('email') ? 'is-invalid' : ''" required
                        autofocus autocomplete="username" class="form-control" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" :class="$errors->get('password') ? 'is-invalid' : ''" required
                        autocomplete="current-password" class="form-control" />
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label text-white-50">
                            {{ __('Remember me') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="text-secondary" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <div class="d-grid mb-3">
                    <x-primary-button class="btn btn-primary btn-lg">
                        {{ __('Log in') }}
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

            <p class="auth-footer mt-4">Don't have an account? Tap Create an account on the left.</p>
        </div>
    </div>
</x-guest-layout>
