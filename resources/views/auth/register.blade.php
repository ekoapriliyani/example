<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('img/logobeva.png') }}" alt="Logo Perusahaan" class="h-16 w-auto object-contain">
        </div>

        <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">
            QC INSPECTION SYSTEM
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Silakan daftarkan akun baru untuk operator / staff QC
        </p>
    </div>

    <hr class="border-gray-200 dark:border-gray-700 mb-6">

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-medium text-gray-700" />
            <x-text-input id="name"
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Masukkan nama lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Perusahaan')" class="font-medium text-gray-700" />
            <x-text-input id="email"
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="contoh@perusahaan.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="font-medium text-gray-700" />
            <x-text-input id="password"
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="font-medium text-gray-700" />
            <x-text-input id="password_confirmation"
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi password Anda" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between pt-2 gap-4">
            <a class="underline text-sm text-gray-600 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
                href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button
                class="w-full sm:w-auto justify-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-150 ease-in-out font-semibold">
                {{ __('Daftar Akun') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
