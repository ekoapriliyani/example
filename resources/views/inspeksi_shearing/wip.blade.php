<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Input Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref: <span class="font-mono font-bold text-indigo-600">{{ $inspeksi_shearing->nomor_inspeksi }}</span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="mb-6 rounded-r-lg border-l-4 border-blue-400 bg-blue-50 p-4 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Sedang menginput data WIP untuk transaksi
                            <strong>{{ $inspeksi_shearing->nomor_inspeksi }}</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_shearing_wip.store') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="inspeksi_shearing_id" value="{{ $inspeksi_shearing->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            {{-- KOLOM NOMOR MATERIAL + SCANNER --}}
                            <div>
                                <x-input-label for="no_material" :value="__('Nomor Material')" />
                                <div class="mt-1 flex gap-2">
                                    <x-text-input id="no_material" name="no_material" type="text"
                                        class="block w-full" :value="old('no_material')" required
                                        placeholder="Masukkan atau scan kode" />

                                    <button type="button" id="btn-scan"
                                        class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-2 text-xs font-semibold uppercase tracking-widest text-white ring-indigo-300 transition duration-150 ease-in-out hover:bg-indigo-700 focus:border-indigo-900 focus:outline-none focus:ring active:bg-indigo-900 disabled:opacity-25">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="ml-1 hidden sm:inline">Scan</span>
                                    </button>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('no_material')" />

                                {{-- KONTAINER UNTUK KAMERA SCANNER (HIDDEN SECARA DEFAULT) --}}
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
                                <x-input-label for="nama_operator" :value="__('Nama Operator')" />
                                <x-text-input id="nama_operator" name="nama_operator" type="text"
                                    class="mt-1 block w-full" :value="old('nama_operator')" required
                                    placeholder="Nama operator mesin" />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_operator')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="p_potong" :value="__('P Potong')" />
                                <div class="relative mt-1">
                                    <x-text-input id="p_potong" name="p_potong" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('p_potong')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('p_potong')" />
                            </div>

                            <div>
                                <x-input-label for="l_potong" :value="__('L Potong')" />
                                <div class="relative mt-1">
                                    <x-text-input id="l_potong" name="l_potong" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('l_potong')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('l_potong')" />
                            </div>

                            <div>
                                <x-input-label for="mesh1" :value="__('Mesh 1')" />
                                <div class="relative mt-1">
                                    <x-text-input id="mesh1" name="mesh1" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('mesh1')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('mesh1')" />
                            </div>
                            <div>
                                <x-input-label for="mesh2" :value="__('Mesh 2')" />
                                <div class="relative mt-1">
                                    <x-text-input id="mesh2" name="mesh2" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('mesh2')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('mesh2')" />
                            </div>

                            <div>
                                <x-input-label for="type" :value="__('Type')" />
                                <select id="type" name="type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="Heavy Galvanized"
                                        {{ old('type') == 'Heavy Galvanized' ? 'selected' : '' }}>
                                        Heavy Galvanized
                                    </option>
                                    <option value="PVC" {{ old('type') == 'PVC' ? 'selected' : '' }}>
                                        PVC
                                    </option>
                                    <option value="HDPE" {{ old('type') == 'HDPE' ? 'selected' : '' }}>
                                        HDPE
                                    </option>
                                    <option value="Bezilum Class 1"
                                        {{ old('type') == 'Bezilum Class 1' ? 'selected' : '' }}>
                                        Bezilum Class 1
                                    </option>
                                    <option value="Bezilum Class 2"
                                        {{ old('type') == 'Bezilum Class 2' ? 'selected' : '' }}>
                                        Bezilum Class 2
                                    </option>
                                    <option value="Bezilum Class 3"
                                        {{ old('type') == 'Bezilum Class 3' ? 'selected' : '' }}>
                                        Bezilum Class 3
                                    </option>
                                    <option value="Light Galvanized"
                                        {{ old('type') == 'Light Galvanized' ? 'selected' : '' }}>
                                        Light Galvanized
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('type')" />
                            </div>

                            <div>
                                <x-input-label for="visual" :value="__('Visual')" />
                                <div class="relative mt-1">
                                    <select id="visual" name="visual"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="OK" {{ old('visual') == 'OK' ? 'selected' : '' }}>OK
                                        </option>
                                        <option value="NG" {{ old('visual') == 'NG' ? 'selected' : '' }}>NG
                                        </option>
                                    </select>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('visual')" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <div class="relative mt-1">
                                    <select id="status" name="status"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="OK" {{ old('status') == 'OK' ? 'selected' : '' }}>OK
                                        </option>
                                        <option value="NG" {{ old('status') == 'NG' ? 'selected' : '' }}>NG
                                        </option>
                                    </select>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-6 md:col-span-2">
                            <h3 class="mb-4 font-semibold text-gray-700">Detail Inspeksi</h3>

                            <div id="detail-wrapper" class="space-y-4">
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <div>
                                        <x-input-label for="detail_description_0" :value="__('Description')" />
                                        <select id="detail_description_0" name="detail_description[]"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="OK">OK</option>
                                            <option value="LAS (LEPAS/TIDAK NGELAS)">LAS (LEPAS/TIDAK NGELAS)
                                            </option>
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
                                        <x-input-label for="detail_description2_0" :value="__('Description 2')" />
                                        <select id="detail_description2_0" name="detail_description2[]"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="OK">OK</option>
                                            <option value="LAS (LEPAS/TIDAK NGELAS)">LAS (LEPAS/TIDAK NGELAS)
                                            </option>
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
                                        <x-input-label for="detail_qty_0" :value="__('QTY')" />
                                        <x-text-input id="detail_qty_0" name="detail_qty[]" type="number"
                                            class="mt-1 block w-full" placeholder="QTY" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="add-detail"
                                    class="rounded-md bg-indigo-600 px-3 py-1 text-sm text-white hover:bg-indigo-700">
                                    + Tambah Detail
                                </button>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="files" :value="__('Upload Gambar / File')" />
                                <input id="files" name="files[]" type="file"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" multiple
                                    accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                                {{-- <x-input-error class="mt-2" :messages="$errors->get('files')" />
                                <x-input-error class="mt-2" :messages="$errors->get('files.*')" /> --}}
                                @error('files')
                                    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                                @error('files.*')
                                    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                            <a href="{{ route('inspeksi_shearing.show', $inspeksi_shearing->id) }}"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Simpan Data WIP') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- MEMANGGIL LIBRARY SCANNER BARCODE UNTUK WEB (Html5-Qrcode) VIA CDN --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        // --- LOGIK BARCODE SCANNER ---
        let html5QrcodeScanner = null;

        document.getElementById('btn-scan').addEventListener('click', function() {
            const container = document.getElementById('scanner-container');

            // Toggle container tampilan kamera
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
            document.getElementById('scanner-container').add('hidden');
        });

        function startScanner() {
            // Inisialisasi scanner pada elemen #reader
            html5QrcodeScanner = new Html5Qrcode("reader");

            const config = {
                fps: 10, // Kecepatan frame per detik
                qrbox: {
                    width: 250,
                    height: 150
                } // Ukuran kotak target scan (persegi panjang cocok untuk barcode)
            };

            // Menjalankan kamera belakang secara default ('environment')
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
            // Memasukkan hasil scan ke input nomor material
            document.getElementById('no_material').value = decodedText;

            // Hentikan kamera setelah berhasil scan
            stopScanner();
            document.getElementById('scanner-container').classList.add('hidden');

            // Berikan efek flash hijau tipis penanda sukses
            const inputField = document.getElementById('no_material');
            inputField.classList.add('border-green-500', 'ring', 'ring-green-200');
            setTimeout(() => {
                inputField.classList.remove('border-green-500', 'ring', 'ring-green-200');
            }, 1500);
        }

        function onScanFailure(error) {
            // Kegagalan scan berkala diabaikan karena kamera terus mencari kode aktif
            console.warn(`Pencarian barcode gagal: ${error}`);
        }

        function stopScanner() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner = null;
                }).catch((err) => {
                    console.error("Gagal mematikan kamera.", err);
                });
            }
        }


        // add detail
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
                <label for="detail_qty_${index}" class="block text-sm font-medium text-gray-700">QTY</label>
                <input id="detail_qty_${index}" name="detail_qty[]" type="number"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="QTY" />
            </div>
        </div>`;
            wrapper.insertAdjacentHTML('beforeend', newDetail);
        });
    </script>
</x-app-layout>
