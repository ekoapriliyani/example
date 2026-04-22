<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah PRO Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            xxxxxxx
                        </p>
                    </div>
                    <form action="{{ route('pro.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="pro_id" :value="__('PRO ID')" />
                            <x-text-input id="pro_id" name="pro_id" type="text" class="mt-1 block w-full"
                                :value="old('pro_id')" placeholder="" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('pro_id')" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full"
                                :value="old('description')" placeholder="" required />
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                        <div>
                            <x-input-label for="qty" :value="__('QTY')" />
                            <x-text-input id="qty" name="qty" type="number" class="mt-1 block w-full"
                                :value="old('qty')" placeholder="" required />
                            <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('pro.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button>
                                {{ __('Simpan PRO') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
