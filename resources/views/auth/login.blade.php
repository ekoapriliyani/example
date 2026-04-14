<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('img/logobeva.png') }}" alt="Logo PT Bevananda Mustika" class="h-20 w-auto shadow-sm">
        </div>

        <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-wider">
            Sistem Informasi
        </h2>
        <h3 class="text-lg font-medium text-maroon-700 italic">
            Quality Control Inspection
        </h3>
        <p class="text-sm text-gray-500 font-semibold mt-1">
            PT Bevananda Mustika
        </p>

        <div class="mt-4 h-1 w-12 bg-red-800 mx-auto rounded-full"></div>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email / Username')" class="text-gray-700 font-bold" />
            <x-text-input id="email"
                class="block mt-1 w-full border-gray-300 focus:border-red-800 focus:ring-red-800 shadow-sm"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="user@bevananda.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-bold" />
            <x-text-input id="password"
                class="block mt-1 w-full border-gray-300 focus:border-red-800 focus:ring-red-800 shadow-sm"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-red-800 shadow-sm focus:ring-red-800" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-red-800 hover:text-red-900 font-semibold underline"
                    href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-red-900 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700 transition duration-150 ease-in-out uppercase tracking-widest">
                {{ __('Masuk Ke Sistem') }}
            </button>
        </div>
    </form>

    <div class="mt-8 text-center border-t pt-4">
        <p class="text-xs text-gray-400">
            &copy; {{ date('Y') }} PT Bevananda Mustika. All Rights Reserved.
        </p>
    </div>
</x-guest-layout>
