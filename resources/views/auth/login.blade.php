<x-guest-layout>
     

    {{-- Return to Home --}}
    <div class="text-center mb-4">
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 text-sm">
            &larr; Return to Home
        </a>
    </div>

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me --}}
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-4">
                {{ __('Login') }}
            </x-primary-button>
        </div>

        {{-- Additional Links --}}
        <div class="mt-4 ml-24 flex justify-between">
            <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                {{ __("Don't have an account? Register") }}
            </a>

            
        </div>
    </form>
</x-guest-layout>
