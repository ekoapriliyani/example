<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Project Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            Silakan isi detail proyek di bawah ini. Pastikan memilih Subkon yang tepat untuk
                            sinkronisasi data.
                        </p>
                    </div>

                    <form action="{{ route('project.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="subkon_id" :value="__('Pilih Subkon')" />
                            <select id="subkon_id" name="subkon_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="" disabled selected>-- Pilih Subkon --</option>
                                @foreach ($subkons as $subkon)
                                    <option value="{{ $subkon->id }}"
                                        {{ old('subkon_id') == $subkon->id ? 'selected' : '' }}>
                                        {{ $subkon->name }} ({{ $subkon->subkon_id }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('subkon_id')" />
                        </div>

                        <div>
                            <x-input-label for="id_project" :value="__('Project ID')" />
                            <x-text-input id="id_project" name="id_project" type="text" class="mt-1 block w-full"
                                :value="old('id_project')" placeholder="Contoh: PRJ-001" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('id_project')" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nama Project')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name')" placeholder="Masukkan nama project" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="no_pro" :value="__('Nomor PRO')" />
                                <x-text-input id="no_pro" name="no_pro" type="text" class="mt-1 block w-full"
                                    :value="old('no_pro')" placeholder="No. Produksi" required />
                                <x-input-error class="mt-2" :messages="$errors->get('no_pro')" />
                            </div>

                            <div>
                                <x-input-label for="qty" :value="__('Quantity (QTY)')" />
                                <x-text-input id="qty" name="qty" type="number" class="mt-1 block w-full"
                                    :value="old('qty')" placeholder="0" required />
                                <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('project.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button>
                                {{ __('Simpan Project') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
