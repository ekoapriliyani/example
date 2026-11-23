<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Tambah Mechanical Test Wire Rope') }}
            </h2>

            <a href="{{ route('incomingwirerope.show', $incomingwirerope->id) }}"
                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">

            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">

                    <div class="mb-6 rounded-lg border border-indigo-100 bg-indigo-50 p-4">
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-1 text-sm text-gray-700">
                            <span>Nomor Inspeksi:
                                <span class="font-semibold text-gray-900">{{ $incomingwirerope->nomor_inspeksi }}</span>
                            </span>
                            <span>Supplier:
                                <span class="font-semibold text-gray-900">{{ $incomingwirerope->supplier->nama ?? '-' }}</span>
                            </span>
                            <span>No PO:
                                <span class="font-semibold text-gray-900">{{ $incomingwirerope->no_po }}</span>
                            </span>
                        </div>
                    </div>

                    @if ($inspeksis->isEmpty())
                        <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-800">
                            Semua No Koil sudah memiliki data Mechanical Test, atau belum ada data Inspeksi Wire Rope.
                            Silakan tambahkan data Inspeksi Wire Rope terlebih dahulu.
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('incomingwirerope.show', $incomingwirerope->id) }}"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">
                                Kembali
                            </a>
                        </div>
                    @else
                        <form action="{{ route('incomingwirerope.mechanical_test.store', $incomingwirerope->id) }}"
                            method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                                <div class="md:col-span-2">
                                    <x-input-label for="inspeksi_id" :value="__('No Koil')" />
                                    <div class="mt-1 flex gap-2">
                                        <select id="inspeksi_id" name="inspeksi_id"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required>
                                            <option value="">-- Pilih No Koil --</option>
                                            @foreach ($inspeksis as $row)
                                                <option value="{{ $row->id }}"
                                                    data-no-koil="{{ $row->no_koil }}"
                                                    {{ (string) old('inspeksi_id', request('inspeksi')) === (string) $row->id ? 'selected' : '' }}>
                                                    {{ $row->no_koil }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="button" id="btn-scan"
                                            class="inline-flex items-center rounded border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-indigo-700 focus:outline-none">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="ml-1 hidden sm:inline">Scan</span>
                                        </button>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('inspeksi_id')" />

                                    <div id="scanner-container" class="mt-4 hidden rounded-lg border bg-gray-50 p-4">
                                        <div class="mb-2 flex items-center justify-between">
                                            <span class="text-sm font-semibold text-gray-700">Kamera Scanner Aktif</span>
                                            <button type="button" id="btn-close-scanner"
                                                class="text-xs text-red-600 hover:underline">Tutup Kamera</button>
                                        </div>
                                        <div id="reader" class="mx-auto w-full overflow-hidden rounded-md"
                                            style="max-width: 400px;"></div>
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="mechanical_status" :value="__('Status')" />
                                    <select id="mechanical_status" name="mechanical_status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                        <option value="" disabled
                                            {{ old('mechanical_status') ? '' : 'selected' }}>-- Pilih Status --</option>
                                        <option value="OK"
                                            {{ old('mechanical_status') == 'OK' ? 'selected' : '' }}>OK</option>
                                        <option value="NG"
                                            {{ old('mechanical_status') == 'NG' ? 'selected' : '' }}>NG</option>
                                        <option value="REJECT"
                                            {{ old('mechanical_status') == 'REJECT' ? 'selected' : '' }}>REJECT</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('mechanical_status')" />
                                </div>

                                <div>
                                    <x-input-label for="tensile_strength_kawat_inti"
                                        :value="__('Tensile Strength Kawat Inti (MPa)')" />
                                    <x-text-input id="tensile_strength_kawat_inti"
                                        name="tensile_strength_kawat_inti" type="number" step="0.01"
                                        class="mt-1 block w-full" :value="old('tensile_strength_kawat_inti')"
                                        placeholder="0.00" required />
                                    <x-input-error class="mt-2"
                                        :messages="$errors->get('tensile_strength_kawat_inti')" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="files" :value="__('Upload File / Gambar')" />
                                <input id="files" name="files[]" type="file" accept="image/*,.pdf"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" multiple>
                                @error('files')
                                    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                                @error('files.*')
                                    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-4">
                                <a href="{{ route('incomingwirerope.show', $incomingwirerope->id) }}"
                                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">
                                    {{ __('Batal') }}
                                </a>

                                <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                                    {{ __('Simpan') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (!$inspeksis->isEmpty())
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

        <script>
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
                        width: 280,
                        height: 130
                    }
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

            function onScanSuccess(decodedText) {
                const select = document.getElementById('inspeksi_id');
                let found = false;

                for (const option of select.options) {
                    if (option.dataset.noKoil === decodedText) {
                        select.value = option.value;
                        found = true;
                        break;
                    }
                }

                stopScanner();
                document.getElementById('scanner-container').classList.add('hidden');

                const inputField = select;
                inputField.classList.add('border-green-500', 'ring', 'ring-green-200');
                setTimeout(() => {
                    inputField.classList.remove('border-green-500', 'ring', 'ring-green-200');
                }, 1500);

                if (!found) {
                    alert('No Koil "' + decodedText + '" tidak ditemukan pada daftar inspeksi.');
                }
            }

            function onScanFailure(error) {
                console.warn('Mencari barcode koil aktif...');
            }

            function stopScanner() {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.stop().then(() => {
                        html5QrcodeScanner = null;
                    }).catch((err) => {
                        console.error("Gagal menghentikan stream kamera.", err);
                    });
                }
            }
        </script>
    @endif
</x-app-layout>
