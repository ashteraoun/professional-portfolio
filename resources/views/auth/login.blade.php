<x-guest-layout>
    <div class="auth-heading">
        <p class="auth-form-eyebrow">Welcome back</p>
        <h2>Sign in to your account</h2>
        <p>Enter your details below to continue.</p>
    </div>

    <x-auth-session-status class="auth-session-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <x-input-label for="email" :value="__('Email address')" class="auth-label" />
            <div class="auth-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><rect x="3.5" y="5" width="17" height="14" rx="2" stroke-width="1.6"/><path d="m4.5 7 7.5 5.5L19.5 7" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <x-text-input id="email" class="auth-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <div class="auth-field">
            <div class="auth-label-row">
                <x-input-label for="password" :value="__('Password')" class="auth-label" />
                @if (Route::has('password.request'))
                    <a class="auth-forgot-link" href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
                @endif
            </div>
            <div class="auth-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><rect x="4.5" y="10" width="15" height="11" rx="2" stroke-width="1.6"/><path d="M8 10V7a4 4 0 1 1 8 0v3m-4 4v3" stroke-width="1.6" stroke-linecap="round"/></svg>
                <x-text-input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <label for="remember_me" class="auth-remember">
            <input id="remember_me" type="checkbox" name="remember">
            <span>{{ __('Remember me') }}</span>
        </label>

        <button type="submit" class="auth-submit-button">
            <span>{{ __('Sign in') }}</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
    </form>

    <p class="auth-signup-note">Your portfolio workspace, all in one place.</p>
</x-guest-layout>
