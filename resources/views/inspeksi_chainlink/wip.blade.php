<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Input Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref: <span class="font-mono font-bold text-indigo-600">{{ $inspeksiChainlink->nomor_inspeksi }}</span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg shadow-sm">
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
                            <strong>{{ $inspeksiChainlink->nomor_inspeksi }}</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    <form action="{{ route('inspeksi_chainlink_wip.store') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="inspeksi_chainlink_id" value="{{ $inspeksiChainlink->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="lebar" :value="__('Lebar')" />
                                <div class="relative mt-1">
                                    <x-text-input id="lebar" name="lebar" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('lebar')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('lebar')" />
                            </div>
                            <div>
                                <x-input-label for="panjang" :value="__('Panjang')" />
                                <div class="relative mt-1">
                                    <x-text-input id="panjang" name="panjang" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('panjang')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('panjang')" />
                            </div>
                            <div>
                                <x-input-label for="p_mesh" :value="__('P Mesh')" />
                                <div class="relative mt-1">
                                    <x-text-input id="p_mesh" name="p_mesh" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('p_mesh')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('p_mesh')" />
                            </div>
                            <div>
                                <x-input-label for="l_mesh" :value="__('L Mesh')" />
                                <div class="relative mt-1">
                                    <x-text-input id="l_mesh" name="l_mesh" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('l_mesh')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('l_mesh')" />
                            </div>
                            <div>
                                <x-input-label for="diameter_inti" :value="__('diameter_inti')" />
                                <div class="relative mt-1">
                                    <x-text-input id="diameter_inti" name="diameter_inti" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('diameter_inti')" placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('diameter_inti')" />
                            </div>
                            <div>
                                <x-input-label for="diameter_luar" :value="__('diameter_luar')" />
                                <div class="relative mt-1">
                                    <x-text-input id="diameter_luar" name="diameter_luar" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('diameter_luar')" placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('diameter_luar')" />
                            </div>
                            <div>
                                <x-input-label for="type" :value="__('Type')" />
                                <select id="type" name="type"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih Type --</option>
                                    <option value="PVC" {{ old('type') == 'PVC' ? 'selected' : '' }}>PVC</option>
                                    <option value="ULTRA" {{ old('type') == 'ULTRA' ? 'selected' : '' }}>ULTRA
                                    </option>
                                    <option value="HG" {{ old('type') == 'HG' ? 'selected' : '' }}>HG</option>
                                    <option value="LG" {{ old('type') == 'LG' ? 'selected' : '' }}>LG</option>
                                    <option value="HDPE" {{ old('type') == 'HDPE' ? 'selected' : '' }}>HDPE</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('type')" />
                            </div>
                            <div>
                                <x-input-label for="model" :value="__('Model')" />
                                <select id="model" name="model"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih Model --</option>
                                    <option value="Twisted-Twisted"
                                        {{ old('model') == 'Twisted-Twisted' ? 'selected' : '' }}>
                                        Twisted-Twisted
                                    </option>
                                    <option value="Twisted-Knuckle"
                                        {{ old('model') == 'Twisted-Knuckle' ? 'selected' : '' }}>
                                        Twisted-Knuckle
                                    </option>
                                    <option value="Knuckle-Knuckle"
                                        {{ old('model') == 'Knuckle-Knuckle' ? 'selected' : '' }}>
                                        Knuckle-Knuckle
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('model')" />
                            </div>
                            <div>
                                <x-input-label for="warna" :value="__('Warna')" />
                                <select id="warna" name="warna"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Pilih Warna --</option>
                                    <option value="Hijau" {{ old('warna') == 'Hijau' ? 'selected' : '' }}>
                                        Hijau
                                    </option>
                                    <option value="Abu-Abu" {{ old('warna') == 'Abu-Abu' ? 'selected' : '' }}>
                                        Abu-Abu
                                    </option>
                                    <option value="Biru" {{ old('warna') == 'Biru' ? 'selected' : '' }}>
                                        Biru
                                    </option>
                                    <option value="Putih" {{ old('warna') == 'Putih' ? 'selected' : '' }}>
                                        Putih
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('warna')" />
                            </div>
                            <div>
                                <x-input-label for="visual" :value="__('Visual')" />
                                <select id="visual" name="visual"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih visual --</option>
                                    <option value="OK" {{ old('visual') == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NG" {{ old('visual') == 'NG' ? 'selected' : '' }}>NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="OK" {{ old('status') == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NG" {{ old('status') == 'NG' ? 'selected' : '' }}>NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <div>
                                <x-input-label for="weight" :value="__('weight')" />
                                <div class="relative mt-1">
                                    <x-text-input id="weight" name="weight" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('weight')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        kg
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
                            </div>

                        </div>
                        <div class="md:col-span-2 border-t border-gray-200 pt-6">
                            <h3 class="font-semibold text-gray-700 mb-4">Detail Inspeksi</h3>
                            <div id="detail-wrapper" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <x-input-label for="detail_description_0" :value="__('Description')" />
                                        <select id="detail_description_0" name="detail_description[]"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="CRACK">CRACK</option>
                                            <option value="MESH">MESH</option>
                                            <option value="PANJANG OUT">PANJANG OUT</option>
                                            <option value="LEBAR OUT">LEBAR OUT</option>
                                            <option value="PVC PECAH">PVC PECAH</option>
                                            <option value="WHITE RUST">WHITE RUST</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="detail_description2_0" :value="__('Description 2')" />
                                        <select id="detail_description2_0" name="detail_description2[]"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="CRACK">CRACK</option>
                                            <option value="MESH">MESH</option>
                                            <option value="PANJANG OUT">PANJANG OUT</option>
                                            <option value="LEBAR OUT">LEBAR OUT</option>
                                            <option value="PVC PECAH">PVC PECAH</option>
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
                                    class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                                    + Tambah Detail
                                </button>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="files" :value="__('Upload Gambar / File')" />
                                <input id="files" name="files[]" type="file"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" multiple
                                    accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                                {{-- <x-input-error class="mt-2" :messages="$errors->get('files')" />
                                <x-input-error class="mt-2" :messages="$errors->get('files.*')" /> --}}
                                @error('files')
                                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                                @enderror
                                @error('files.*')
                                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('inspeksi_chainlink.show', $inspeksiChainlink->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
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
                    <option value="DIAMETER OUT">DIAMETER OUT</option>
                    <option value="CRACK">CRACK</option>
                    <option value="MESH">MESH</option>
                    <option value="PANJANG OUT">PANJANG OUT</option>
                    <option value="LEBAR OUT">LEBAR OUT</option>
                    <option value="PVC PECAH">PVC PECAH</option>
                    <option value="WHITE RUST">WHITE RUST</option>
                </select>
            </div>
            <div>
                <label for="detail_description2_${index}" class="block text-sm font-medium text-gray-700">Description 2</label>
                <select id="detail_description2_${index}" name="detail_description2[]"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih Detail --</option>
                    <option value="DIAMETER OUT">DIAMETER OUT</option>
                    <option value="CRACK">CRACK</option>
                    <option value="MESH">MESH</option>
                    <option value="PANJANG OUT">PANJANG OUT</option>
                    <option value="LEBAR OUT">LEBAR OUT</option>
                    <option value="PVC PECAH">PVC PECAH</option>
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
