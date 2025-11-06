<x-guest-layout>
    <div>

        {{-- Return to Home --}}
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center gap-1 text-gray-600 hover:text-blue-600 text-sm font-medium transition">
                ← Back to Home
            </a>
        </div>

        {{-- Registration Card --}}
        <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Create an Account</h1>
                <p class="text-gray-500 text-sm">Join VibeTube and start sharing your moments 🎥</p>
            </div>

            {{-- Registration Form --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 font-medium" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-medium" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-600 hover:text-blue-600 font-medium transition">
                        Already registered?
                    </a>

                    <x-primary-button class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-semibold shadow-md transition">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        
    </div>
</x-guest-layout>
