<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Mesin Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            Daftarkan aset mesin baru.
                        </p>
                    </div>

                    <form action="{{ route('mesin.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="mesin_id" :value="__('ID Mesin')" />
                            <x-text-input id="mesin_id" name="mesin_id" type="text" class="mt-1 block w-full"
                                :value="old('mesin_id')" placeholder="Contoh: MSN-001" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('mesin_id')" />
                        </div>

                        <div>
                            <x-input-label for="nama_mesin" :value="__('Nama Mesin')" />
                            <x-text-input id="nama_mesin" name="nama_mesin" type="text" class="mt-1 block w-full"
                                :value="old('nama_mesin')" placeholder="Contoh: High Speed Milling" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_mesin')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('mesin.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button>
                                {{ __('Simpan Mesin') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
