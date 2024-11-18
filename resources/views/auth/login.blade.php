<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- add notes for default admin and password -->
        <div class="mt-10">
            <hr>
            <h2 style="text-align: center;">NOTES</h2>
            <hr>
            <p class="text-sm text-gray-600 items-center mt-5">Default admin email: <b>admin@admin.com</b></p>
            <p class="text-sm text-gray-600 items-center">Default admin password: <b>password</b></p>
            <center><button type="button" class="mt-4 text-center block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600" onclick="fillDefaultAdmin()">Fill Default Admin Credential</button></center>
        </div>
    </form>

    <script>
        function fillDefaultAdmin() {
            document.getElementById('email').value = 'admin@admin.com';
            document.getElementById('password').value = 'password';
        }
    </script>
</x-guest-layout>
