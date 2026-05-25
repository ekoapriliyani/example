<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Input Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref: <span class="font-mono font-bold text-indigo-600">{{ $inspeksiCt->nomor_inspeksi }}</span>
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
                            <strong>{{ $inspeksiCt->nomor_inspeksi }}</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_ct_wip.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        <input type="hidden" name="inspeksi_ct_id" value="{{ $inspeksiCt->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div>
                                <x-input-label for="no_material" :value="__('Nomor Material')" />
                                <x-text-input id="no_material" name="no_material" type="number"
                                    class="mt-1 block w-full" :value="old('no_material')" required
                                    placeholder="Masukkan kode material" />
                                <x-input-error class="mt-2" :messages="$errors->get('no_material')" />
                            </div>

                            <div>
                                <x-input-label for="nama_operator" :value="__('Nama Operator')" />
                                <x-text-input id="nama_operator" name="nama_operator" type="text"
                                    class="mt-1 block w-full" :value="old('nama_operator')" required
                                    placeholder="Nama operator mesin" />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_operator')" />
                            </div>

                            <div>
                                <x-input-label for="d_kawat_act" :value="__('Diameter Kawat Aktual')" />
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
                                <x-input-label for="p_produk" :value="__('Panjang Produk')" />
                                <div class="relative mt-1">
                                    <x-text-input id="p_produk" name="p_produk" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('p_produk')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('p_produk')" />
                            </div>
                            <div>
                                <x-input-label for="l_produk" :value="__('Lebar Produk')" />
                                <div class="relative mt-1">
                                    <x-text-input id="l_produk" name="l_produk" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('l_produk')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('l_produk')" />
                            </div>
                            <div>
                                <x-input-label for="t_produk" :value="__('Tinggi Produk')" />
                                <div class="relative mt-1">
                                    <x-text-input id="t_produk" name="t_produk" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('t_produk')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('t_produk')" />
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
                                <x-input-label for="mesh3" :value="__('Mesh 3')" />
                                <div class="relative mt-1">
                                    <x-text-input id="mesh3" name="mesh3" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('mesh3')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('mesh3')" />
                            </div>

                            <div>
                                <x-input-label for="diagonal" :value="__('Diagonal')" />
                                <div class="relative mt-1">
                                    <x-text-input id="diagonal" name="diagonal" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('diagonal')" required placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('diagonal')" />
                            </div>

                            <div>
                                <x-input-label for="visual" :value="__('Visual')" />
                                <select id="visual" name="visual"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    {{-- <option value="">-- Pilih visual --</option> --}}
                                    <option value="OK" {{ old('visual') == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NG" {{ old('visual') == 'NG' ? 'selected' : '' }}>NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('visual')" />
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    {{-- <option value="">-- Pilih Status --</option> --}}
                                    <option value="OK" {{ old('status') == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NG" {{ old('status') == 'NG' ? 'selected' : '' }}>NG</option>
                                </select>
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
                            <a href="{{ route('inspeksi_ct.show', $inspeksiCt->id) }}"
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

    <script>
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
                <label for="detail_description2_${index}" class="block text-sm font-medium text-gray-700">Description 2</label>
                <select id="detail_description2_${index}" name="detail_description2[]"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih Detail --</option>
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
                <label for="detail_qty_${index}" class="block text-sm font-medium text-gray-700">QTY</label>
                <input id="detail_qty_${index}" name="detail_qty[]" type="number"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="QTY" />
            </div>
        </div>`;
            wrapper.insertAdjacentHTML('beforeend', newDetail);
        });
    </script>
</x-app-layout>
