<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Input Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref: <span class="font-mono font-bold text-indigo-600">{{ $inspeksi_pvc->nomor_inspeksi }}</span>
            </p>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div
                class="mb-6 rounded-xl border-l-4 border-blue-500 bg-blue-50 p-4 shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-blue-800">
                            Sedang menginput data WIP untuk transaksi nomor:
                            <span
                                class="bg-blue-200 text-blue-900 px-2 py-0.5 rounded font-mono font-bold">{{ $inspeksi_pvc->nomor_inspeksi }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">

                <div class="bg-indigo-600 px-8 py-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-white">Input Pencatatan Data WIP</h2>
                    <p class="text-sm text-indigo-100 mt-1">
                        Silakan lengkapi parameter material, temperatur mesin, dan item detail inspeksi.
                    </p>
                </div>

                <div class="p-8 text-gray-900">
                    <form action="{{ route('inspeksi_pvc_wip.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-8">
                        @csrf
                        <input type="hidden" name="inspeksi_pvc_id" value="{{ $inspeksi_pvc->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Log Material & Personel
                            </h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                {{-- KOLOM NOMOR MATERIAL 1 + SCANNER --}}
                                <div>
                                    <x-input-label for="no_material" :value="__('Nomor Material Kawat')" />
                                    <div class="mt-1 flex gap-2">
                                        <x-text-input id="no_material" name="no_material" type="text"
                                            class="block w-full py-3" :value="old('no_material')" required
                                            placeholder="Masukkan atau scan kode" />

                                        <button type="button" id="btn-scan-1"
                                            class="inline-flex items-center rounded-lg border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white ring-indigo-300 transition duration-150 ease-in-out hover:bg-indigo-700 focus:outline-none shadow-sm">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="ml-1 hidden sm:inline">Scan</span>
                                        </button>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('no_material')" />

                                    {{-- KONTAINER UNTUK KAMERA SCANNER 1 --}}
                                    <div id="scanner-container-1"
                                        class="mt-4 hidden rounded-lg border border-gray-200 bg-gray-50 p-4 shadow-sm">
                                        <div class="mb-2 flex items-center justify-between">
                                            <span class="text-sm font-semibold text-gray-700">Kamera Scanner Kawat
                                                Aktif</span>
                                            <button type="button" id="btn-close-scanner-1"
                                                class="text-xs text-red-600 hover:underline font-medium">Tutup
                                                Kamera</button>
                                        </div>
                                        <div id="reader-1"
                                            class="mx-auto w-full overflow-hidden rounded-md border border-gray-300 bg-white"
                                            style="max-width: 400px;"></div>
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="nama_operator" :value="__('Nama Operator')" />
                                    <x-text-input id="nama_operator" name="nama_operator" type="text"
                                        class="mt-1 block w-full py-3" :value="old('nama_operator')" required
                                        placeholder="Nama operator mesin" />
                                    <x-input-error class="mt-2" :messages="$errors->get('nama_operator')" />
                                </div>

                                {{-- KOLOM NOMOR MATERIAL 2 + SCANNER --}}
                                <div>
                                    <x-input-label for="no_material2" :value="__('Nomor Material Bubuk PVC/HDPE')" />
                                    <div class="mt-1 flex gap-2">
                                        <x-text-input id="no_material2" name="no_material2" type="text"
                                            class="block w-full py-3" :value="old('no_material2')" required
                                            placeholder="Masukkan atau scan kode" />

                                        <button type="button" id="btn-scan-2"
                                            class="inline-flex items-center rounded-lg border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white ring-indigo-300 transition duration-150 ease-in-out hover:bg-indigo-700 focus:outline-none shadow-sm">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="ml-1 hidden sm:inline">Scan</span>
                                        </button>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('no_material2')" />

                                    {{-- KONTAINER UNTUK KAMERA SCANNER 2 --}}
                                    <div id="scanner-container-2"
                                        class="mt-4 hidden rounded-lg border border-gray-200 bg-gray-50 p-4 shadow-sm">
                                        <div class="mb-2 flex items-center justify-between">
                                            <span class="text-sm font-semibold text-gray-700">Kamera Scanner Bubuk
                                                Aktif</span>
                                            <button type="button" id="btn-close-scanner-2"
                                                class="text-xs text-red-600 hover:underline font-medium">Tutup
                                                Kamera</button>
                                        </div>
                                        <div id="reader-2"
                                            class="mx-auto w-full overflow-hidden rounded-md border border-gray-300 bg-white"
                                            style="max-width: 400px;"></div>
                                    </div>
                                </div>

                                <div class="hidden md:block"></div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Monitoring Parameter
                                Temperatur</h3>
                            <div class="grid grid-cols-2 gap-6 md:grid-cols-5">
                                @foreach (['c1' => 'Cylinder 1', 'c2' => 'Cylinder 2', 'c3' => 'Cylinder 3', 'c4' => 'Cylinder 4', 'ch' => 'Cross Head'] as $name => $label)
                                    <div>
                                        <x-input-label for="{{ $name }}" :value="__($label)" />
                                        <div class="relative mt-1">
                                            <x-text-input id="{{ $name }}" name="{{ $name }}"
                                                type="number" step="0.01" class="block w-full pr-10 py-3"
                                                :value="old($name)" required placeholder="0.00" />
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm font-semibold text-gray-400">
                                                °C
                                            </div>
                                        </div>
                                        <x-input-error class="mt-2" :messages="$errors->get($name)" />
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Dimensi & Pengujian
                                Fisik</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <x-input-label for="d_kawat_inti" :value="__('Diameter Kawat Inti')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="d_kawat_inti" name="d_kawat_inti" type="number"
                                            step="0.01" class="block w-full pr-12 py-3" :value="old('d_kawat_inti')" required
                                            placeholder="0.00" />
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                            mm</div>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('d_kawat_inti')" />
                                </div>

                                <div>
                                    <x-input-label for="d_kawat_pvc" :value="__('Diameter Kawat PVC/HDPE')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="d_kawat_pvc" name="d_kawat_pvc" type="number"
                                            step="0.01" class="block w-full pr-12 py-3" :value="old('d_kawat_pvc')" required
                                            placeholder="0.00" />
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                            mm</div>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('d_kawat_pvc')" />
                                </div>

                                <div>
                                    <x-input-label for="penyimpangan" :value="__('Penyimpangan')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="penyimpangan" name="penyimpangan" type="number"
                                            step="0.01" class="block w-full pr-12 py-3" :value="old('penyimpangan')" required
                                            placeholder="0.00" />
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                            mm</div>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('penyimpangan')" />
                                </div>

                                <div>
                                    <x-input-label for="warna" :value="__('Warna')" />
                                    <select id="warna" name="warna"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3">
                                        @foreach (['Abu-Abu', 'Biru', 'Hijau', 'Hitam', 'Putih'] as $w)
                                            <option value="{{ $w }}"
                                                {{ old('warna') == $w ? 'selected' : '' }}>{{ $w }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('warna')" />
                                </div>

                                <div>
                                    <x-input-label for="uji_lilit" :value="__('Uji Lilit')" />
                                    <select id="uji_lilit" name="uji_lilit"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3">
                                        <option value="OK" {{ old('uji_lilit') == 'OK' ? 'selected' : '' }}>OK
                                        </option>
                                        <option value="NG" {{ old('uji_lilit') == 'NG' ? 'selected' : '' }}>NG
                                        </option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('uji_lilit')" />
                                </div>

                                <div>
                                    <x-input-label for="visual" :value="__('Visual')" />
                                    <select id="visual" name="visual"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3">
                                        <option value="OK" {{ old('visual') == 'OK' ? 'selected' : '' }}>OK
                                        </option>
                                        <option value="NG" {{ old('visual') == 'NG' ? 'selected' : '' }}>NG
                                        </option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('visual')" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Form Rincian Deviasi /
                                Detail Inspeksi</h3>

                            <div id="detail-wrapper" class="space-y-4">
                                <div
                                    class="grid grid-cols-1 gap-4 md:grid-cols-3 items-end bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                    <div>
                                        <x-input-label for="detail_description_0" :value="__('Description 1')" class="mb-1" />
                                        <select id="detail_description_0" name="detail_description[]"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 text-sm">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="OK">OK</option>
                                            <option value="LAS (LEPAS/TIDAK NGELAS)">LAS (LEPAS/TIDAK NGELAS)</option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="TEBAL OUT">TEBAL OUT</option>
                                            <option value="PANJANG OUT">PANJANG OUT</option>
                                            <option value="LEBAR OUT">LEBAR OUT</option>
                                            <option value="TINGGI OUT">TINGGI OUT</option>
                                            <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                                            <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                                            <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS
                                            </option>
                                            <option value="OVERHANG OUT">OVERHANG OUT</option>
                                            <option value="KARAT">KARAT</option>
                                            <option value="WHITE RUST">WHITE RUST</option>
                                            <option value="TRIMING">TRIMING</option>
                                            <option value="CRACK">CRACK</option>
                                            <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                                            <option value="PVC/HDPE PECAH/SOBEK">PVC/HDPE PECAH/SOBEK</option>
                                            <option value="PVC/HDPE MIRING">PVC/HDPE MIRING</option>
                                            <option value="PVC/HDPE KASAR">PVC/HDPE KASAR</option>
                                            <option value="JARAK DURI/BLADE">JARAK DURI/BLADE</option>
                                            <option value="BLADE PECAH/SOBEK">BLADE PECAH/SOBEK</option>
                                            <option value="PISAU POUNCH TUMPUL">PISAU POUNCH TUMPUL</option>
                                            <option value="BENDING TIDAK PRESS">BENDING TIDAK PRESS</option>
                                            <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="detail_description2_0" :value="__('Description 2 (Opsional)')"
                                            class="mb-1" />
                                        <select id="detail_description2_0" name="detail_description2[]"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 text-sm">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="OK">OK</option>
                                            <option value="LAS (LEPAS/TIDAK NGELAS)">LAS (LEPAS/TIDAK NGELAS)</option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="TEBAL OUT">TEBAL OUT</option>
                                            <option value="PANJANG OUT">PANJANG OUT</option>
                                            <option value="LEBAR OUT">LEBAR OUT</option>
                                            <option value="TINGGI OUT">TINGGI OUT</option>
                                            <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                                            <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                                            <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS
                                            </option>
                                            <option value="OVERHANG OUT">OVERHANG OUT</option>
                                            <option value="KARAT">KARAT</option>
                                            <option value="WHITE RUST">WHITE RUST</option>
                                            <option value="TRIMING">TRIMING</option>
                                            <option value="CRACK">CRACK</option>
                                            <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                                            <option value="PVC/HDPE PECAH/SOBEK">PVC/HDPE PECAH/SOBEK</option>
                                            <option value="PVC/HDPE MIRING">PVC/HDPE MIRING</option>
                                            <option value="PVC/HDPE KASAR">PVC/HDPE KASAR</option>
                                            <option value="JARAK DURI/BLADE">JARAK DURI/BLADE</option>
                                            <option value="BLADE PECAH/SOBEK">BLADE PECAH/SOBEK</option>
                                            <option value="PISAU POUNCH TUMPUL">PISAU POUNCH TUMPUL</option>
                                            <option value="BENDING TIDAK PRESS">BENDING TIDAK PRESS</option>
                                            <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="detail_qty_0" :value="__('QTY Defect')" class="mb-1" />
                                        <x-text-input id="detail_qty_0" name="detail_qty[]" type="number"
                                            class="block w-full py-2" placeholder="0" />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex justify-start">
                                <button type="button" id="add-detail"
                                    class="inline-flex items-center rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all shadow-sm">
                                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Baris Detail
                                </button>
                            </div>

                            <div class="mt-6 border-t border-gray-200 pt-6">
                                <x-input-label for="files" :value="__('Upload Evidence / Gambar Pendukung')" class="mb-2" />
                                <div class="flex items-center justify-center w-full">
                                    <label
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-white hover:bg-gray-50 transition-all">
                                        <div
                                            class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                            </svg>
                                            <p class="text-sm text-gray-500"><span class="font-semibold">Tap untuk
                                                    memilih file</span> gambar atau dokumen penunjang</p>
                                            <p class="text-xs text-gray-400 mt-1">Format: Images, PDF, Word, Excel
                                                (Bisa pilih banyak sekaligus)</p>
                                        </div>
                                        <input id="files" name="files[]" type="file" class="hidden" multiple
                                            accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                                    </label>
                                </div>

                                @error('files')
                                    <div class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</div>
                                @enderror
                                @error('files.*')
                                    <div class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
                            <a href="{{ route('inspeksi_pvc.show', $inspeksi_pvc->id) }}"
                                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                                {{ __('Batal') }}
                            </a>

                            <button type="submit"
                                class="inline-flex items-center rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold uppercase tracking-widest text-white shadow-md transition duration-150 ease-in-out hover:bg-indigo-700 focus:outline-none">
                                {{ __('Simpan Data WIP') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MEMANGGIL LIBRARY SCANNER BARCODE UNTUK WEB (Html5-Qrcode) VIA CDN --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        // --- LOGIK BARCODE SCANNER DINAMIS ---
        let html5QrcodeScanner = null;
        let isScannerStopping = false;
        let activeScannerId = null; // Menyimpan ID scanner yang sedang berjalan ('1' atau '2')

        // Inisialisasi Event Listener untuk Scanner 1
        document.getElementById('btn-scan-1').addEventListener('click', function() {
            toggleScanner('1', 'scanner-container-1', 'reader-1', 'no_material');
        });
        document.getElementById('btn-close-scanner-1').addEventListener('click', function() {
            forceCloseActiveScanner();
        });

        // Inisialisasi Event Listener untuk Scanner 2
        document.getElementById('btn-scan-2').addEventListener('click', function() {
            toggleScanner('2', 'scanner-container-2', 'reader-2', 'no_material2');
        });
        document.getElementById('btn-close-scanner-2').addEventListener('click', function() {
            forceCloseActiveScanner();
        });

        /**
         * Mengatur buka-tutup kamera secara dinamis
         */
        function toggleScanner(id, containerId, readerId, inputId) {
            if (isScannerStopping) return;

            const container = document.getElementById(containerId);

            // Jika ada scanner lain yang sedang terbuka, matikan dulu sebelum membuka yang baru
            if (html5QrcodeScanner && activeScannerId !== id) {
                stopScanner(() => {
                    hideAllContainers();
                    container.classList.remove('hidden');
                    startScanner(id, readerId, containerId, inputId);
                });
                return;
            }

            if (container.classList.contains('hidden')) {
                hideAllContainers(); // Tutup container lainnya jika ada
                container.classList.remove('hidden');
                startScanner(id, readerId, containerId, inputId);
            } else {
                stopScanner(() => {
                    container.classList.add('hidden');
                });
            }
        }

        /**
         * Menjalankan engine scanner spesifik berdasarkan parameter
         */
        function startScanner(id, readerId, containerId, inputId) {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }

            html5QrcodeScanner = new Html5Qrcode(readerId);
            activeScannerId = id;

            const config = {
                fps: 15,
                qrbox: {
                    width: 280,
                    height: 160
                },
                aspectRatio: 1.777778 // Rasio 16:9 agar kamera responsif di tablet portrait/landscape
            };

            html5QrcodeScanner.start({
                    facingMode: "environment"
                },
                config,
                (decodedText, decodedResult) => {
                    // Callback Sukses Scan
                    const inputField = document.getElementById(inputId);
                    if (inputField) {
                        inputField.value = decodedText;
                        inputField.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));

                        // Efek visual flash sukses hijau pada input target
                        inputField.classList.add('border-green-500', 'ring', 'ring-green-200');
                        setTimeout(() => {
                            inputField.classList.remove('border-green-500', 'ring', 'ring-green-200');
                        }, 1500);
                    }

                    stopScanner(() => {
                        document.getElementById(containerId).classList.add('hidden');
                    });
                },
                (error) => {
                    // Kegagalan berkala diabaikan karena kamera terus looping mencari kode
                    console.warn(`Mencari kode pada scanner ${id}...`);
                }
            ).catch((err) => {
                alert("Gagal mengakses kamera: " + err);
                document.getElementById(containerId).classList.add('hidden');
                html5QrcodeScanner = null;
                activeScannerId = null;
            });
        }

        /**
         * Mematikan engine scanner secara asinkron (Aman dari Race Condition)
         */
        function stopScanner(callback = null) {
            if (html5QrcodeScanner && !isScannerStopping) {
                isScannerStopping = true;

                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner = null;
                    activeScannerId = null;
                    isScannerStopping = false;
                    if (callback) callback();
                }).catch((err) => {
                    console.error("Gagal menonaktifkan komponen kamera.", err);
                    isScannerStopping = false;
                    if (callback) callback();
                });
            } else {
                if (callback) callback();
            }
        }

        /**
         * Helper untuk menyembunyikan semua box container kamera di UI
         */
        function hideAllContainers() {
            document.getElementById('scanner-container-1').classList.add('hidden');
            document.getElementById('scanner-container-2').classList.add('hidden');
        }

        /**
         * Fungsi paksa tutup dari tombol "Tutup Kamera"
         */
        function forceCloseActiveScanner() {
            if (isScannerStopping) return;
            stopScanner(() => {
                hideAllContainers();
            });
        }

        // --- LOGIK TAMBAH DETAIL FIELD (BAWAAN ANDA) ---
        document.getElementById('add-detail').addEventListener('click', function() {
            let wrapper = document.getElementById('detail-wrapper');
            let index = wrapper.children.length;
            let newDetail = `
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="detail_description_${index}" class="block text-sm font-medium text-gray-700">Description</label>
                    <select id="detail_description_${index}" name="detail_description[]"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Detail --</option>
                        <option value="OK">OK</option>
                        <option value="LAS (LEPAS/TIDAK NGELAS)">LAS (LEPAS/TIDAK NGELAS)</option>
                        <option value="DIAMETER OUT">DIAMETER OUT</option>
                        <option value="TEBAL OUT">TEBAL OUT</option>
                        <option value="PANJANG OUT">PANJANG OUT</option>
                        <option value="LEBAR OUT">LEBAR OUT</option>
                        <option value="TINGGI OUT">TINGGI OUT</option>
                        <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                        <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                        <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS</option>
                        <option value="OVERHANG OUT">OVERHANG OUT</option>
                        <option value="KARAT">KARAT</option>
                        <option value="WHITE RUST">WHITE RUST</option>
                        <option value="TRIMING">TRIMING</option>
                        <option value="CRACK">CRACK</option>
                        <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                        <option value="PVC/HDPE PECAH/SOBEK">PVC/HDPE PECAH/SOBEK</option>
                        <option value="PVC/HDPE MIRING">PVC/HDPE MIRING</option>
                        <option value="PVC/HDPE KASAR">PVC/HDPE KASAR</option>
                        <option value="JARAK DURI/BLADE">JARAK DURI/BLADE</option>
                        <option value="BLADE PECAH/SOBEK">BLADE PECAH/SOBEK</option>
                        <option value="PISAU POUNCH TUMPUL">PISAU POUNCH TUMPUL</option>
                        <option value="BENDING TIDAK PRESS">BENDING TIDAK PRESS</option>
                        <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                    </select>
                </div>
                <div>
                    <label for="detail_description2_${index}" class="block text-sm font-medium text-gray-700">Description 2</label>
                    <select id="detail_description2_${index}" name="detail_description2[]"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Detail --</option>
                        <option value="OK">OK</option>
                        <option value="LAS (LEPAS/TIDAK NGELAS)">LAS (LEPAS/TIDAK NGELAS)</option>
                        <option value="DIAMETER OUT">DIAMETER OUT</option>
                        <option value="TEBAL OUT">TEBAL OUT</option>
                        <option value="PANJANG OUT">PANJANG OUT</option>
                        <option value="LEBAR OUT">LEBAR OUT</option>
                        <option value="TINGGI OUT">TINGGI OUT</option>
                        <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                        <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                        <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS</option>
                        <option value="OVERHANG OUT">OVERHANG OUT</option>
                        <option value="KARAT">KARAT</option>
                        <option value="WHITE RUST">WHITE RUST</option>
                        <option value="TRIMING">TRIMING</option>
                        <option value="CRACK">CRACK</option>
                        <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                        <option value="PVC/HDPE PECAH/SOBEK">PVC/HDPE PECAH/SOBEK</option>
                        <option value="PVC/HDPE MIRING">PVC/HDPE MIRING</option>
                        <option value="PVC/HDPE KASAR">PVC/HDPE KASAR</option>
                        <option value="JARAK DURI/BLADE">JARAK DURI/BLADE</option>
                        <option value="BLADE PECAH/SOBEK">BLADE PECAH/SOBEK</option>
                        <option value="PISAU POUNCH TUMPUL">PISAU POUNCH TUMPUL</option>
                        <option value="BENDING TIDAK PRESS">BENDING TIDAK PRESS</option>
                        <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                    </select>
                </div>
                <div>
                    <label for="detail_qty_${index}" class="block text-sm font-medium text-gray-700">QTY</label>
                    <input id="detail_qty_${index}" name="detail_qty[]" type="number"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="QTY" />
                </div>
            </div>`;
            wrapper.insertAdjacentHTML('beforeend', newDetail);
        });
    </script>
</x-app-layout>
