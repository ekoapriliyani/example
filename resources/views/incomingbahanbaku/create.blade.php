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
                            Silahkan isi data hasil pengecekan incoming bahan baku koil di bawah ini dengan benar.
                        </p>
                    </div>

                    <form action="{{ route('incomingbahanbaku.store') }}" method="POST" class="space-y-6"
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

                        {{-- SEKSI INPUT NO KOIL + SCANNER BARCODE --}}
                        <div>
                            <x-input-label for="no_koil" :value="__('Nomor Koil')" />
                            <div class="flex gap-2 mt-1">
                                <x-text-input id="no_koil" name="no_koil" type="text" class="block w-full"
                                    :value="old('no_koil')" placeholder="Masukkan atau scan nomor koil" required />

                                <button type="button" id="btn-scan"
                                    class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="ml-1 hidden sm:inline">Scan</span>
                                </button>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('no_koil')" />

                            {{-- KONTAINER VIEWPORT KAMERA --}}
                            <div id="scanner-container" class="mt-4 hidden p-4 bg-gray-50 border rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-gray-700">Kamera Scanner Aktif</span>
                                    <button type="button" id="btn-close-scanner"
                                        class="text-xs text-red-600 hover:underline">Tutup Kamera</button>
                                </div>
                                <div id="reader" class="w-full mx-auto overflow-hidden rounded-md"
                                    style="max-width: 400px;"></div>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="d_kawat" :value="__('D Kawat')" />
                            <div class="relative mt-1">
                                <select id="d_kawat" name="d_kawat" class="block w-full border rounded px-3 py-2">
                                    <option value="">-- Pilih Diameter --</option>
                                    <option value="1.6">1.6</option>
                                    <option value="1.8">1.8</option>
                                    <option value="2">2</option>
                                    <option value="2.5">2.5</option>
                                    <option value="2.7">2.7</option>
                                    <option value="3">3</option>
                                    <option value="3.2">3.2</option>
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
                                <option value="EP">EP</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_kawat')" />
                        </div>
                        <div>
                            <x-input-label for="certificate" :value="__('Certificate')" />
                            <div class="relative mt-1">
                                <x-text-input id="certificate" name="certificate" type="text"
                                    class="block w-full pr-12" :value="old('certificate')" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('certificate')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="files" :value="__('Upload File')" />

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

    {{-- LIBRARY HTML5-QRCODE VIA CDN --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 bawaan Anda
            $('#supplier_id').select2({
                placeholder: '-- Pilih Supplier --',
                allowClear: true,
                width: '100%'
            });
        });

        // --- LOGIK BARCODE SCANNER NO KOIL ---
        let html5QrcodeScanner = null;

        document.getElementById('btn-scan').addEventListener('click', function() {
            const container = document.getElementById('scanner-container');

            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                startScanner();
            } else {
                stopScanner();
                container.classList.add('hidden');
            }
        });

        document.getElementById('btn-close-scanner').addEventListener('click', function() {
            stopScanner();
            document.getElementById('scanner-container').classList.add('hidden');
        });

        function startScanner() {
            html5QrcodeScanner = new Html5Qrcode("reader");

            const config = {
                fps: 10,
                qrbox: {
                    width: 260,
                    height: 140
                } // Sangat pas untuk label memanjang pada label koil
            };

            html5QrcodeScanner.start({
                    facingMode: "environment"
                },
                config,
                onScanSuccess,
                onScanFailure
            ).catch((err) => {
                alert("Gagal mengakses kamera: " + err);
                document.getElementById('scanner-container').classList.add('hidden');
            });
        }

        function onScanSuccess(decodedText, decodedResult) {
            // Masukkan teks barcode ke field no_koil
            document.getElementById('no_koil').value = decodedText;

            stopScanner();
            document.getElementById('scanner-container').classList.add('hidden');

            // Efek kilatan hijau sukses input
            const inputField = document.getElementById('no_koil');
            inputField.classList.add('border-green-500', 'ring', 'ring-green-200');
            setTimeout(() => {
                inputField.classList.remove('border-green-500', 'ring', 'ring-green-200');
            }, 1500);
        }

        function onScanFailure(error) {
            // Pencarian log diabaikan agar tidak memenuhi konsol dev-tools
            console.warn(`Mencari kode barcode koil...`);
        }

        function stopScanner() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner = null;
                }).catch((err) => {
                    console.error("Gagal menonaktifkan kamera stream.", err);
                });
            }
        }
    </script>
</x-app-layout>
