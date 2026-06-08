<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Tambah Mechanical Test') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('incomingbahanbaku.mechanical_test.store', $incomingbahanbaku->id) }}"
                    method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Koil</label>
                        <div class="flex gap-2">
                            <input type="text" id="nomor_koil" name="nomor_koil"
                                class="w-full border rounded px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"
                                required autofocus placeholder="Masukkan atau scan nomor koil">

                            <button type="button" id="btn-scan"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="ml-1 hidden sm:inline">Scan</span>
                            </button>
                        </div>

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
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Tensile (MPa)</label>
                            <input type="number" step="0.01" name="hasil_tensile"
                                class="w-full border rounded px-3 py-2" required placeholder="0.00">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Coating Weight</label>
                            <input type="number" step="0.01" name="hasil_coatingweight"
                                class="w-full border rounded px-3 py-2" required placeholder="0.00">
                        </div>

                        <div class="mb-4">
                            <label for="hasil_lilit" class="block text-sm font-medium text-gray-700 mb-1">Hasil
                                Lilit</label>
                            <select id="hasil_lilit" name="hasil_lilit" class="w-full border rounded px-3 py-2">
                                <option value="OK" {{ old('hasil_lilit') == 'OK' ? 'selected' : '' }}>OK</option>
                                <option value="CRACK" {{ old('hasil_lilit') == 'CRACK' ? 'selected' : '' }}>CRACK
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Puntir</label>
                            <input type="number" step="0.01" name="hasil_puntir"
                                class="w-full border rounded px-3 py-2" required placeholder="0.00">
                        </div>
                        {{-- description jika NG --}}
                        <div class="mb-4">
                            <label for="description1">Description 1
                                <span class="text-red-600 text-sm">(Isi jika NG)</span>
                            </label>
                            <select id="description1" name="description1" class="w-full border rounded px-3 py-2">
                                <option value="" {{ old('description1') == '' ? 'selected' : '' }}>-- PILIH
                                    DESKRIPSI --</option>
                                <option value="KARAT" {{ old('description1') == 'KARAT' ? 'selected' : '' }}>KARAT
                                </option>
                                <option value="WHITE RUST" {{ old('description1') == 'WHITE RUST' ? 'selected' : '' }}>
                                    WHITE RUST</option>
                                <option value="CRACK/FLAKING"
                                    {{ old('description1') == 'CRACK/FLAKING' ? 'selected' : '' }}>CRACK/FLAKING
                                </option>
                                <option value="RUAS BAMBU" {{ old('description1') == 'RUAS BAMBU' ? 'selected' : '' }}>
                                    RUAS BAMBU</option>
                                <option value="BINTIK HITAM"
                                    {{ old('description1') == 'BINTIK HITAM' ? 'selected' : '' }}>BINTIK HITAM</option>
                                <option value="DIAMETER OUT"
                                    {{ old('description1') == 'DIAMETER OUT' ? 'selected' : '' }}>DIAMETER OUT</option>
                                <option value="TENSILE OUT"
                                    {{ old('description1') == 'TENSILE OUT' ? 'selected' : '' }}>TENSILE OUT</option>
                                <option value="COATING OUT"
                                    {{ old('description1') == 'COATING OUT' ? 'selected' : '' }}>COATING OUT</option>
                                <option value="PUNTIR OUT" {{ old('description1') == 'PUNTIR OUT' ? 'selected' : '' }}>
                                    PUNTIR OUT</option>
                                <option value="LILIT OUT" {{ old('description1') == 'LILIT OUT' ? 'selected' : '' }}>
                                    LILIT OUT</option>
                            </select>
                        </div>


                        <div class="mb-4">
                            <label for="description2">Description 2
                                <span class="text-red-600 text-sm">(Isi jika NG)</span>
                            </label>
                            <select id="description2" name="description2" class="w-full border rounded px-3 py-2">
                                <option value="" {{ old('description2') == '' ? 'selected' : '' }}>-- PILIH
                                    DESKRIPSI --</option>
                                <option value="KARAT" {{ old('description2') == 'KARAT' ? 'selected' : '' }}>KARAT
                                </option>
                                <option value="WHITE RUST" {{ old('description2') == 'WHITE RUST' ? 'selected' : '' }}>
                                    WHITE RUST</option>
                                <option value="CRACK/FLAKING"
                                    {{ old('description2') == 'CRACK/FLAKING' ? 'selected' : '' }}>CRACK/FLAKING
                                </option>
                                <option value="RUAS BAMBU" {{ old('description2') == 'RUAS BAMBU' ? 'selected' : '' }}>
                                    RUAS BAMBU</option>
                                <option value="BINTIK HITAM"
                                    {{ old('description2') == 'BINTIK HITAM' ? 'selected' : '' }}>BINTIK HITAM</option>
                                <option value="DIAMETER OUT"
                                    {{ old('description2') == 'DIAMETER OUT' ? 'selected' : '' }}>DIAMETER OUT</option>
                                <option value="TENSILE OUT"
                                    {{ old('description2') == 'TENSILE OUT' ? 'selected' : '' }}>TENSILE OUT</option>
                                <option value="COATING OUT"
                                    {{ old('description2') == 'COATING OUT' ? 'selected' : '' }}>COATING OUT</option>
                                <option value="PUNTIR OUT"
                                    {{ old('description2') == 'PUNTIR OUT' ? 'selected' : '' }}>
                                    PUNTIR OUT</option>
                                <option value="LILIT OUT" {{ old('description2') == 'LILIT OUT' ? 'selected' : '' }}>
                                    LILIT OUT</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" name="status" class="w-full border rounded px-3 py-2">
                                <option value="OK" {{ old('status') == 'OK' ? 'selected' : '' }}>OK</option>
                                <option value="NG" {{ old('status') == 'NG' ? 'selected' : '' }}>NG
                                </option>
                            </select>
                        </div>
                        {{-- upload file --}}
                        <div class="mt-4">
                            <x-input-label for="files" :value="__('Upload File')" />
                            <input id="files" name="files[]" type="file"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" multiple>
                            @error('files')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                            @enderror
                            @error('files.*')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('incomingbahanbaku.show', $incomingbahanbaku->id) }}"
                            class="px-4 py-2 bg-gray-300 rounded text-sm font-medium text-gray-700 hover:bg-gray-400 transition">
                            Batal
                        </a>

                        <button
                            class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-medium hover:bg-blue-700 transition">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- LIBRARY HTML5-QRCODE VIA CDN --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        // --- LOGIK BARCODE SCANNER NOMOR KOIL ---
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
                } // Fokus dimensi horizontal label koil
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
            // Memasukkan hasil scan ke input nomor_koil
            document.getElementById('nomor_koil').value = decodedText;

            stopScanner();
            document.getElementById('scanner-container').classList.add('hidden');

            // Efek kilatan hijau pada border penanda input sukses
            const inputField = document.getElementById('nomor_koil');
            inputField.classList.add('border-green-500', 'ring', 'ring-green-200');
            setTimeout(() => {
                inputField.classList.remove('border-green-500', 'ring', 'ring-green-200');
            }, 1500);
        }

        function onScanFailure(error) {
            console.warn(`Mencari kode barcode koil aktif...`);
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
