<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Outgoing') }}
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

                    <form action="{{ route('outgoing.store') }}" method="POST" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        <div>
                            <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi (Otomatis)')" />
                            <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                class="mt-1 block w-full bg-gray-100" value="{{ $nextNomor }}" readonly />
                        </div>
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal')" />
                            <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full"
                                value="{{ old('tanggal', now()->format('Y-m-d')) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                        </div>
                        {{-- <div>
                            <x-input-label for="shipment_id" :value="__('Pilih shipment')" />
                            <select id="shipment_id" name="shipment_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih shipment --</option>
                                @foreach ($shipments as $shipment)
                                    <option value="{{ $shipment->id }}"
                                        {{ old('shipment_id') == $shipment->id ? 'selected' : '' }}>
                                        {{ $shipment->shipment_id }} - {{ $shipment->custname }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('shipment_id')" />
                        </div> --}}

                        <div>
                            <x-input-label for="no_do" :value="__('Nomor DO')" />
                            <div class="relative mt-1">
                                <x-text-input id="no_do" name="no_do" type="text" class="block w-full pr-12"
                                    :value="old('no_do')" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('no_do')" />
                        </div>

                        <div>
                            <x-input-label for="produk" :value="__('Produk')" />
                            <div class="relative mt-1">
                                <x-text-input id="produk" name="produk" type="text" class="block w-full pr-12"
                                    :value="old('produk')" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('produk')" />
                        </div>

                        <div>
                            <x-input-label for="lokasi" :value="__('Lokasi')" />
                            <div class="relative mt-1">
                                <x-text-input id="lokasi" name="lokasi" type="text" class="block w-full pr-12"
                                    :value="old('lokasi')" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('lokasi')" />
                        </div>
                        <div>
                            <x-input-label for="no_kendaraan" :value="__('No Kendaraan')" />
                            <div class="relative mt-1">
                                <x-text-input id="no_kendaraan" name="no_kendaraan" type="text"
                                    class="block w-full pr-12" :value="old('no_kendaraan')" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('no_kendaraan')" />
                        </div>
                        <div>
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <div class="relative mt-1">
                                <x-text-input id="keterangan" name="keterangan" type="text"
                                    class="block w-full pr-12" :value="old('keterangan')" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="files" :value="__('Upload Surat Jalan')" />

                            <input id="files" name="files[]" type="file" accept="image/*,.pdf"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" multiple>

                            @error('files')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                            @enderror

                            @error('files.*')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('outgoing.index') }}"
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

            $('#shipment_id').select2({
                placeholder: '-- Pilih shipment --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</x-app-layout>
