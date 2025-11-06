<x-guest-layout>
    <div >

        {{-- Login Card --}}
        <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 border border-gray-200">

            {{-- Return to Home --}}
            <div class="text-center mb-4">
                <a href="{{ route('home') }}" class="text-gray-700 text-gray-600 hover:text-blue-600 font-medium flex items-center justify-center gap-1">
                    <span class="text-lg">←</span> Return to Home
                </a>
            </div>

            {{-- Title --}}
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login to Your Account</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" 
                        type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" 
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" 
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 hover:text-blue-600 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                {{-- Login Button --}}
                <x-primary-button class="w-full py-2 justify-center">
                    {{ __('Login') }}
                </x-primary-button>
            </form>

            {{-- Additional Links --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">
                        {{ __('Register now') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
