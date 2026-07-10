<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Input Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref: <span class="font-mono font-bold text-indigo-600">{{ $inspeksi_wm->nomor_inspeksi }}</span>
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
                            <strong>{{ $inspeksi_wm->nomor_inspeksi }}</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_wm_wip.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        <input type="hidden" name="inspeksi_wm_id" value="{{ $inspeksi_wm->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            {{-- KOLOM NOMOR MATERIAL + SCANNER BARCODE --}}
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

                                {{-- LAYOUT VIEWPORT KAMERA SCANNER --}}
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
                                <x-input-label for="d_kawat_act" :value="__('Diameter Kawat (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="d_kawat_act" name="d_kawat_act" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('d_kawat_act')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('d_kawat_act')" />
                            </div>

                            <div>
                                <x-input-label for="selisih_diagonal" :value="__('Selisih Diagonal (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="selisih_diagonal" name="selisih_diagonal" type="number"
                                        step="1" class="block w-full pr-12" :value="old('selisih_diagonal')" required
                                        placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('selisih_diagonal')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="p_product_act" :value="__('Panjang Produk (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="p_product_act" name="p_product_act" type="number" step="1"
                                        class="block w-full pr-12" :value="old('p_product_act')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('p_product_act')" />
                            </div>

                            <div>
                                <x-input-label for="l_product_act" :value="__('Lebar Produk (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="l_product_act" name="l_product_act" type="number"
                                        step="1" class="block w-full pr-12" :value="old('l_product_act')" required
                                        placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('l_product_act')" />
                            </div>

                            <div>
                                <x-input-label for="p_mesh_act" :value="__('Panjang Mesh (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="p_mesh_act" name="p_mesh_act" type="number" step="1"
                                        class="block w-full pr-12" :value="old('p_mesh_act')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('p_mesh_act')" />
                            </div>

                            <div>
                                <x-input-label for="l_mesh_act" :value="__('Lebar Mesh (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="l_mesh_act" name="l_mesh_act" type="number" step="1"
                                        class="block w-full pr-12" :value="old('l_mesh_act')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('l_mesh_act')" />
                            </div>

                            <div>
                                <x-input-label for="torsi_strength" :value="__('Torsi Strength')" />
                                <div class="relative mt-1">
                                    <select id="torsi_strength" name="torsi_strength"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="OK" {{ old('torsi_strength') == 'OK' ? 'selected' : '' }}>OK
                                        </option>
                                        <option value="NG" {{ old('torsi_strength') == 'NG' ? 'selected' : '' }}>NG
                                        </option>
                                    </select>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('torsi_strength')" />
                            </div>

                            <div>
                                <x-input-label for="status_dimensi" :value="__('Dimensi')" />
                                <div class="relative mt-1">
                                    <select id="status_dimensi" name="status_dimensi"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="OK" {{ old('status_dimensi') == 'OK' ? 'selected' : '' }}>OK
                                        </option>
                                        <option value="NG" {{ old('status_dimensi') == 'NG' ? 'selected' : '' }}>NG
                                        </option>
                                    </select>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('status_dimensi')" />
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
                                <x-input-label for="shear_strength" :value="__('Shear Strength Min')" />
                                <div class="relative mt-1">
                                    <x-text-input id="shear_strength" name="shear_strength" type="number"
                                        step="0.01" class="block w-full pr-12" :value="old('shear_strength')"
                                        placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mpa
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('shear_strength')" />
                            </div>
                            <div>
                                <x-input-label for="weight" :value="__('Weight')" />
                                <div class="relative mt-1">
                                    <x-text-input id="weight" name="weight" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('weight')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        kg
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
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
                                            <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS
                                            </option>
                                            <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                                            <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="KARAT">KARAT</option>
                                            <option value="LASAN LEPAS">LASAN LEPAS</option>
                                            <option value="LEBAR OUT">LEBAR OUT</option>
                                            <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS
                                            </option>
                                            <option value="OVERHANG OUT">OVERHANG OUT</option>
                                            <option value="PANJANG OUT">PANJANG OUT</option>
                                            <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                                            <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                                            <option value="SALAH TEKUK BENDING">SALAH TEKUK BENDING</option>
                                            <option value="TINGGI OUT">TINGGI OUT</option>
                                            <option value="TRIMING">TRIMING</option>
                                            <option value="WHITE RUST">WHITE RUST</option>
                                            <option value="DOUBLE CROSS WIRE">DOUBLE CROSS WIRE</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="detail_description2_0" :value="__('Description 2')" />
                                        <select id="detail_description2_0" name="detail_description2[]"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS
                                            </option>
                                            <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                                            <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="KARAT">KARAT</option>
                                            <option value="LASAN LEPAS">LASAN LEPAS</option>
                                            <option value="LEBAR OUT">LEBAR OUT</option>
                                            <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS
                                            </option>
                                            <option value="OVERHANG OUT">OVERHANG OUT</option>
                                            <option value="PANJANG OUT">PANJANG OUT</option>
                                            <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                                            <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                                            <option value="SALAH TEKUK BENDING">SALAH TEKUK BENDING</option>
                                            <option value="TINGGI OUT">TINGGI OUT</option>
                                            <option value="TRIMING">TRIMING</option>
                                            <option value="WHITE RUST">WHITE RUST</option>
                                            <option value="DOUBLE CROSS WIRE">DOUBLE CROSS WIRE</option>
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

                                @error('files')
                                    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                                @enderror

                                @error('files.*')
                                    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                            <a href="{{ route('inspeksi_wm.show', $inspeksi_wm->id) }}"
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

    {{-- SCRIPTS ZONE --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        // --- LOGIK BARCODE SCANNER ---
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
                    width: 250,
                    height: 150
                } // Menyesuaikan fokus persegi panjang barcode material
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
            document.getElementById('no_material').value = decodedText;

            stopScanner();
            document.getElementById('scanner-container').classList.add('hidden');

            // Efek visual sukses
            const inputField = document.getElementById('no_material');
            inputField.classList.add('border-green-500', 'ring', 'ring-green-200');
            setTimeout(() => {
                inputField.classList.remove('border-green-500', 'ring', 'ring-green-200');
            }, 1500);
        }

        function onScanFailure(error) {
            console.warn(`Mencari kode: ${error}`);
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

        // --- LOGIK DINAMIS TAMBAH FIELD (BAWAAN WIREMESH) ---
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
                        <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS</option>
                        <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                        <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                        <option value="DIAMETER OUT">DIAMETER OUT</option>
                        <option value="KARAT">KARAT</option>
                        <option value="LASAN LEPAS">LASAN LEPAS</option>
                        <option value="LEBAR OUT">LEBAR OUT</option>
                        <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS</option>
                        <option value="OVERHANG OUT">OVERHANG OUT</option>
                        <option value="PANJANG OUT">PANJANG OUT</option>
                        <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                        <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                        <option value="SALAH TEKUK BENDING">SALAH TEKUK BENDING</option>
                        <option value="TINGGI OUT">TINGGI OUT</option>
                        <option value="TRIMING">TRIMING</option>
                        <option value="WHITE RUST">WHITE RUST</option>
                    </select>
                </div>
                <div>
                    <label for="detail_description2_${index}" class="block text-sm font-medium text-gray-700">Description 2</label>
                    <select id="detail_description2_${index}" name="detail_description2[]"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Detail --</option>
                        <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS</option>
                        <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                        <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                        <option value="DIAMETER OUT">DIAMETER OUT</option>
                        <option value="KARAT">KARAT</option>
                        <option value="LASAN LEPAS">LASAN LEPAS</option>
                        <option value="LEBAR OUT">LEBAR OUT</option>
                        <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS</option>
                        <option value="OVERHANG OUT">OVERHANG OUT</option>
                        <option value="PANJANG OUT">PANJANG OUT</option>
                        <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                        <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                        <option value="SALAH TEKUK BENDING">SALAH TEKUK BENDING</option>
                        <option value="TINGGI OUT">TINGGI OUT</option>
                        <option value="TRIMING">TRIMING</option>
                        <option value="WHITE RUST">WHITE RUST</option>
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
