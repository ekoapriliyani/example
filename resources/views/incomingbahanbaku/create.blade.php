<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Inspeksi Incoming Bahan Baku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            xxxxxxx
                        </p>
                    </div>

                    <form action="{{ route('incomingbahanbaku.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi (Otomatis)')" />
                            <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                class="mt-1 block w-full bg-gray-100" value="{{ $nextNomor }}" readonly />
                        </div>
                        <div class="">
                            <x-input-label for="tanggal" :value="__('Tanggal')" />
                            <input type="date" name="tanggal"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                value="{{ old('tanggal') }}" required>
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                        </div>
                        <div>
                            <x-input-label for="supplier_id" :value="__('Pilih Supplier')" />
                            <select id="supplier_id" name="supplier_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_code') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('supplier_code')" />
                        </div>
                        <div>
                            <x-input-label for="no_po" :value="__('No PO')" />
                            <div class="relative mt-1">
                                <x-text-input id="no_po" name="no_po" type="text" class="block w-full pr-12"
                                    :value="old('no_po')" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('no_po')" />
                        </div>
                        <div>
                            <x-input-label for="no_sj" :value="__('No SJ')" />
                            <div class="relative mt-1">
                                <x-text-input id="no_sj" name="no_sj" type="text" class="block w-full pr-12"
                                    :value="old('no_sj')" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('no_sj')" />
                        </div>
                        <div>
                            <x-input-label for="jml_koil" :value="__('Jml Koil')" />
                            <div class="relative mt-1">
                                <x-text-input id="jml_koil" name="jml_koil" type="number" class="block w-full pr-12"
                                    :value="old('jml_koil')" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('jml_koil')" />
                        </div>
                        <div>
                            <x-input-label for="d_kawat" :value="__('D Kawat')" />
                            <div class="relative mt-1">
                                <select id="d_kawat" name="d_kawat" class="block w-full border rounded px-3 py-2">
                                    <option value="">-- Pilih Diameter --</option>
                                    <option value="1.6">1.6</option>
                                    <option value="2">2</option>
                                    <option value="2.7">2.7</option>
                                    <option value="3">3</option>
                                    <option value="3.4">3.4</option>
                                    <option value="4">4</option>
                                    <option value="5.6">5.6</option>
                                    <option value="8">8</option>
                                </select>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('d_kawat')" />
                        </div>

                        <div>
                            <x-input-label for="tol" :value="__('Toleransi')" />
                            <div class="relative mt-1">
                                <x-text-input id="tol" name="tol" type="number" step="0.01"
                                    class="block w-full pr-12" :value="old('tol')" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('tol')" />
                        </div>

                        <div>
                            <x-input-label for="jenis_kawat" :value="__('Jenis Kawat')" />
                            <select id="jenis_kawat" name="jenis_kawat"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Jenis Kawat --</option>
                                <option value="LG">LG</option>
                                <option value="HG">HG</option>
                                <option value="ULTRA">ULTRA</option>
                                <option value="BLACK WIRE">BLACK WIRE</option>
                                <option value="BEZILUM">BEZILUM</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('supplier_code')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('incomingbahanbaku.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button>
                                {{ __('Simpan Inspeksi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#supplier_id').select2({
                placeholder: '-- Pilih Supplier --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</x-app-layout>
