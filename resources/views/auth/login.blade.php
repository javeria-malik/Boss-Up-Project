<x-guest-layout>
    <div class="flex h-screen">
        <!-- Left Section: Branding -->
        <div class="w-1/2 flex flex-col items-center justify-center bg-gray-800 text-white p-8">
            <img src="{{ asset('img/Boss-Up_Logo.jpg') }}" alt="Boss Up Logo" class="w-48 h-auto">
            <h1 class="text-4xl font-bold mt-4">Boss Up</h1>
            <p class="text-lg mt-2 text-gray-300">Level up your business with us!</p>
        </div>

        <!-- Right Section: Login Form -->
        <div class="w-1/2 flex items-center justify-center p-8">
            <x-authentication-card>
                <x-validation-errors class="mb-4" />

                <!-- Email Verification Message -->
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 text-sm text-green-600">
                        A new verification link has been sent to your email.
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="w-full">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full text-lg p-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full text-lg p-3" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                            {{ __('Register') }}
                        </a>

                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-button class="ml-4">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="flex items-center my-4">
                    <hr class="w-full border-gray-300">
                    <span class="px-3 text-gray-600">OR</span>
                    <hr class="w-full border-gray-300">
                </div>

                <!-- Google Login Button -->
                <div class="flex justify-center">
                    <a href="{{ route('google-auth') }}" class="flex items-center bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                        <img src="{{ asset('img/google-logo.png') }}" alt="Google Logo" class="w-6 h-6 mr-2">
                        Continue with Google
                    </a>
                </div>
            </x-authentication-card>
        </div>
    </div>
</x-guest-layout>
