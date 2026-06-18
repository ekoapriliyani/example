<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Input Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref: <span class="font-mono font-bold text-indigo-600">{{ $inspeksiGabionframe->nomor_inspeksi }}</span>
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
                            <strong>{{ $inspeksiGabionframe->nomor_inspeksi }}</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_gabionframe_wip.store') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="inspeksi_gabionframe_id" value="{{ $inspeksiGabionframe->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="no_material" :value="__('Nomor Material')" />
                                <x-text-input id="no_material" name="no_material" type="number"
                                    class="mt-1 block w-full" :value="old('no_material')" placeholder="Masukkan kode material" />
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
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="p_act" :value="__('P Act')" />
                                <div class="relative mt-1">
                                    <x-text-input id="p_act" name="p_act" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('p_act')" placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('p_act')" />
                            </div>
                            <div>
                                <x-input-label for="l_act" :value="__('L Act')" />
                                <div class="relative mt-1">
                                    <x-text-input id="l_act" name="l_act" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('l_act')" placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('l_act')" />
                            </div>
                            {{-- <div>
                                <x-input-label for="t_act" :value="__('T Act')" />
                                <div class="relative mt-1">
                                    <x-text-input id="t_act" name="t_act" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('t_act')" placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('t_act')" />
                            </div> --}}
                            <div>
                                <x-input-label for="d_kwtGal_anyam" :value="__('D Kawat Galvanized Anyam')" />
                                <div class="relative mt-1">
                                    <x-text-input id="d_kwtGal_anyam" name="d_kwtGal_anyam" type="number"
                                        step="0.01" class="block w-full pr-12" :value="old('d_kwtGal_anyam')"
                                        placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('d_kwtGal_anyam')" />
                            </div>
                            <div>
                                <x-input-label for="d_kwtGal_frame" :value="__('D Kawat Galvanized Frame')" />
                                <div class="relative mt-1">
                                    <x-text-input id="d_kwtGal_frame" name="d_kwtGal_frame" type="number"
                                        step="0.01" class="block w-full pr-12" :value="old('d_kwtGal_frame')"
                                        placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('d_kwtGal_frame')" />
                            </div>
                            <div>
                                <x-input-label for="d_kwtPvc_anyam" :value="__('D Kawat PVC/HDPE Anyam')" />
                                <div class="relative mt-1">
                                    <x-text-input id="d_kwtPvc_anyam" name="d_kwtPvc_anyam" type="number"
                                        step="0.01" class="block w-full pr-12" :value="old('d_kwtPvc_anyam')"
                                        placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('d_kwtPvc_anyam')" />
                            </div>
                            <div>
                                <x-input-label for="d_kwtPvc_frame" :value="__('D Kawat PVC/HDPE Frame')" />
                                <div class="relative mt-1">
                                    <x-text-input id="d_kwtPvc_frame" name="d_kwtPvc_frame" type="number"
                                        step="0.01" class="block w-full pr-12" :value="old('d_kwtPvc_frame')"
                                        placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('d_kwtPvc_frame')" />
                            </div>

                            <div>
                                <x-input-label for="mesh1" :value="__('Mesh 1')" />
                                <div class="relative mt-1">
                                    <x-text-input id="mesh1" name="mesh1" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('mesh1')" placeholder="0.00" />
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
                                        class="block w-full pr-12" :value="old('mesh2')" placeholder="0.00" />
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-400">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('mesh2')" />
                            </div>

                            <div>
                                <x-input-label for="visual" :value="__('Visual')" />
                                <select id="visual" name="visual"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
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
                                            <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS
                                            </option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="KARAT">KARAT</option>
                                            <option value="LEBAR OUT">LEBAR OUT</option>
                                            <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS
                                            </option>
                                            <option value="PANJANG OUT">PANJANG OUT</option>
                                            <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                                            <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                                            <option value="PVC/HDPE KASAR">PVC/HDPE KASAR</option>
                                            <option value="PVC/HDPE MIRING">PVC/HDPE MIRING</option>
                                            <option value="PVC/HDPE PECAH/SOBEK">PVC/HDPE PECAH/SOBEK</option>
                                            <option value="WHITE RUST">WHITE RUST</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="detail_description2_0" :value="__('Description 2')" />
                                        <select id="detail_description2_0" name="detail_description2[]"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS
                                            </option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="KARAT">KARAT</option>
                                            <option value="LEBAR OUT">LEBAR OUT</option>
                                            <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS
                                            </option>
                                            <option value="PANJANG OUT">PANJANG OUT</option>
                                            <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                                            <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                                            <option value="PVC/HDPE KASAR">PVC/HDPE KASAR</option>
                                            <option value="PVC/HDPE MIRING">PVC/HDPE MIRING</option>
                                            <option value="PVC/HDPE PECAH/SOBEK">PVC/HDPE PECAH/SOBEK</option>
                                            <option value="WHITE RUST">WHITE RUST</option>
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
                            <a href="{{ route('inspeksi_gabionframe.show', $inspeksiGabionframe->id) }}"
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
                    <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS</option>
                    <option value="DIAMETER OUT">DIAMETER OUT</option>
                    <option value="KARAT">KARAT</option>
                    <option value="LEBAR OUT">LEBAR OUT</option>
                    <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS</option>
                    <option value="PANJANG OUT">PANJANG OUT</option>
                    <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                    <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                    <option value="PVC/HDPE KASAR">PVC/HDPE KASAR</option>
                    <option value="PVC/HDPE MIRING">PVC/HDPE MIRING</option>
                    <option value="PVC/HDPE PECAH/SOBEK">PVC/HDPE PECAH/SOBEK</option>
                    <option value="WHITE RUST">WHITE RUST</option>
                </select>
            </div>
            <div>
                <label for="detail_description2_${index}" class="block text-sm font-medium text-gray-700">Description 2</label>
                <select id="detail_description2_${index}" name="detail_description2[]"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih Detail --</option>
                    <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS</option>
                    <option value="DIAMETER OUT">DIAMETER OUT</option>
                    <option value="KARAT">KARAT</option>
                    <option value="LEBAR OUT">LEBAR OUT</option>
                    <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS</option>
                    <option value="PANJANG OUT">PANJANG OUT</option>
                    <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                    <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                    <option value="PVC/HDPE KASAR">PVC/HDPE KASAR</option>
                    <option value="PVC/HDPE MIRING">PVC/HDPE MIRING</option>
                    <option value="PVC/HDPE PECAH/SOBEK">PVC/HDPE PECAH/SOBEK</option>
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
