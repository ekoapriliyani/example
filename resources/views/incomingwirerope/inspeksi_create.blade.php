<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Tambah Inspeksi Wire Rope') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">

            <div class="rounded bg-white p-6 shadow">

                <form action="{{ route('incomingwirerope.inspeksi.store', $incomingwirerope->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div class="mb-4">
                        <label class="mb-1 block text-sm font-medium text-gray-700">No Koil</label>
                        <div class="flex gap-2">
                            <input type="text" id="no_koil" name="no_koil"
                                value="{{ old('no_koil') }}"
                                class="w-full rounded border px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"
                                required autofocus placeholder="Masukkan atau scan nomor koil">

                            <button type="button" id="btn-scan"
                                class="inline-flex items-center rounded border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700 focus:border-indigo-900 focus:outline-none focus:ring ring-indigo-300 active:bg-indigo-900">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="ml-1 hidden sm:inline">Scan</span>
                            </button>
                        </div>
                        @error('no_koil')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

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

                    <div class="mb-2 border-t pt-4">
                        <h3 class="text-sm font-bold uppercase tracking-wide text-gray-700">Wire Rope</h3>
                    </div>
                    <div class="mb-4 grid grid-cols-3 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">D1 Wire Rope</label>
                            <input type="number" step="0.01" name="d1_wire_rope" value="{{ old('d1_wire_rope') }}"
                                class="w-full rounded border px-3 py-2" placeholder="0.00">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">D2 Wire Rope</label>
                            <input type="number" step="0.01" name="d2_wire_rope" value="{{ old('d2_wire_rope') }}"
                                class="w-full rounded border px-3 py-2" placeholder="0.00">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">D3 Wire Rope</label>
                            <input type="number" step="0.01" name="d3_wire_rope" value="{{ old('d3_wire_rope') }}"
                                class="w-full rounded border px-3 py-2" placeholder="0.00">
                        </div>
                    </div>

                    <div class="mb-2 border-t pt-4">
                        <h3 class="text-sm font-bold uppercase tracking-wide text-gray-700">Kawat Inti</h3>
                    </div>
                    <div class="mb-4 grid grid-cols-3 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">D1 Kawat Inti</label>
                            <input type="number" step="0.01" name="d1_kawat_inti" value="{{ old('d1_kawat_inti') }}"
                                class="w-full rounded border px-3 py-2" placeholder="0.00">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">D2 Kawat Inti</label>
                            <input type="number" step="0.01" name="d2_kawat_inti" value="{{ old('d2_kawat_inti') }}"
                                class="w-full rounded border px-3 py-2" placeholder="0.00">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">D3 Kawat Inti</label>
                            <input type="number" step="0.01" name="d3_kawat_inti" value="{{ old('d3_kawat_inti') }}"
                                class="w-full rounded border px-3 py-2" placeholder="0.00">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Jml Kawat Inti</label>
                            <input type="number" name="jml_kawat_inti" value="{{ old('jml_kawat_inti') }}"
                                class="w-full rounded border px-3 py-2" placeholder="0">
                        </div>
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="dimensi">Dimensi</label>
                            <select id="dimensi" name="dimensi" class="w-full rounded border px-3 py-2">
                                <option value="OK" {{ old('dimensi') == 'OK' ? 'selected' : '' }}>OK</option>
                                <option value="NG" {{ old('dimensi') == 'NG' ? 'selected' : '' }}>NG</option>
                                <option value="REJECT" {{ old('dimensi') == 'REJECT' ? 'selected' : '' }}>REJECT</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="visual">Visual</label>
                            <select id="visual" name="visual" class="w-full rounded border px-3 py-2">
                                <option value="OK" {{ old('visual') == 'OK' ? 'selected' : '' }}>OK</option>
                                <option value="NG" {{ old('visual') == 'NG' ? 'selected' : '' }}>NG</option>
                                <option value="REJECT" {{ old('visual') == 'REJECT' ? 'selected' : '' }}>REJECT</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="description1">Description 1
                                <span class="text-sm text-red-600">(Isi jika NG)</span>
                            </label>
                            <select id="description1" name="description1" class="w-full rounded border px-3 py-2">
                                <option value="" {{ old('description1') == '' ? 'selected' : '' }}>-- PILIH
                                    DESKRIPSI --</option>
                                @foreach (['KARAT', 'WHITE RUST', 'CRACK/FLAKING', 'RUAS BAMBU', 'BINTIK HITAM', 'DIAMETER OUT', 'TENSILE OUT', 'COATING OUT', 'PUNTIR OUT', 'LILIT OUT'] as $desc)
                                    <option value="{{ $desc }}"
                                        {{ old('description1') == $desc ? 'selected' : '' }}>{{ $desc }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="description2">Description 2
                                <span class="text-sm text-red-600">(Isi jika NG)</span>
                            </label>
                            <select id="description2" name="description2" class="w-full rounded border px-3 py-2">
                                <option value="" {{ old('description2') == '' ? 'selected' : '' }}>-- PILIH
                                    DESKRIPSI --</option>
                                @foreach (['KARAT', 'WHITE RUST', 'CRACK/FLAKING', 'RUAS BAMBU', 'BINTIK HITAM', 'DIAMETER OUT', 'TENSILE OUT', 'COATING OUT', 'PUNTIR OUT', 'LILIT OUT'] as $desc)
                                    <option value="{{ $desc }}"
                                        {{ old('description2') == $desc ? 'selected' : '' }}>{{ $desc }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
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

                    <div class="flex justify-end gap-2 border-t border-gray-100 pt-4">
                        <a href="{{ route('incomingwirerope.show', $incomingwirerope->id) }}"
                            class="rounded bg-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-400">
                            Batal
                        </a>

                        <button
                            class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

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

        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('no_koil').value = decodedText;

            stopScanner();
            document.getElementById('scanner-container').classList.add('hidden');

            const inputField = document.getElementById('no_koil');
            inputField.classList.add('border-green-500', 'ring', 'ring-green-200');
            setTimeout(() => {
                inputField.classList.remove('border-green-500', 'ring', 'ring-green-200');
            }, 1500);
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
</x-app-layout>
