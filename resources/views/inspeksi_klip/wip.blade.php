<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Input Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref: <span class="font-mono font-bold text-indigo-600">{{ $inspeksiKlip->nomor_inspeksi }}</span>
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
                            <strong>{{ $inspeksiKlip->nomor_inspeksi }}</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    <form action="{{ route('inspeksi_klip_wip.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        <input type="hidden" name="inspeksi_klip_id" value="{{ $inspeksiKlip->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="no_material" :value="__('Nomor Material')" />
                                <x-text-input id="no_material" name="no_material" type="text" autofocus
                                    class="mt-1 block w-full" :value="old('no_material')" placeholder="Nomor material" />
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
                                <x-input-label for="jml_klip" :value="__('Jumlah Klip')" />
                                <div class="relative mt-1">
                                    <x-text-input id="jml_klip" name="jml_klip" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('jml_klip')" placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        pcs
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('jml_klip')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="d_razor" :value="__('Diameter Razor')" />
                                <div class="relative mt-1">
                                    <x-text-input id="d_razor" name="d_razor" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('d_razor')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('d_razor')" />
                            </div>
                            <div>
                                <x-input-label for="jml_spiral" :value="__('Jumlah Spiral')" />
                                <div class="relative mt-1">
                                    <x-text-input id="jml_spiral" name="jml_spiral" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('jml_spiral')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        turn
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('jml_spiral')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                            <div>
                                <x-input-label for="jarak_antar_klip1" :value="__('Jarak Antar Klip 1')" />
                                <div class="relative mt-1">
                                    <x-text-input id="jarak_antar_klip1" name="jarak_antar_klip1" type="number"
                                        step="0.01" class="block w-full pr-12" :value="old('jarak_antar_klip1')" required
                                        placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        blade
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('jarak_antar_klip1')" />
                            </div>
                            <div>
                                <x-input-label for="jarak_antar_klip2" :value="__('Jarak Antar Klip 2')" />
                                <div class="relative mt-1">
                                    <x-text-input id="jarak_antar_klip2" name="jarak_antar_klip2" type="number"
                                        step="0.01" class="block w-full pr-12" :value="old('jarak_antar_klip2')" required
                                        placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        blade
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('jarak_antar_klip2')" />
                            </div>
                            <div>
                                <x-input-label for="jarak_antar_klip3" :value="__('Jarak Antar Klip 3')" />
                                <div class="relative mt-1">
                                    <x-text-input id="jarak_antar_klip3" name="jarak_antar_klip3" type="number"
                                        step="0.01" class="block w-full pr-12" :value="old('jarak_antar_klip3')" required
                                        placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        blade
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('jarak_antar_klip3')" />
                            </div>
                            <div>
                                <x-input-label for="jarak_antar_klip4" :value="__('Jarak Antar Klip 4')" />
                                <div class="relative mt-1">
                                    <x-text-input id="jarak_antar_klip4" name="jarak_antar_klip4" type="number"
                                        step="0.01" class="block w-full pr-12" :value="old('jarak_antar_klip4')" required
                                        placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        blade
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('jarak_antar_klip4')" />
                            </div>
                            <div>
                                <x-input-label for="jarak_antar_klip5" :value="__('Jarak Antar Klip 5')" />
                                <div class="relative mt-1">
                                    <x-text-input id="jarak_antar_klip5" name="jarak_antar_klip5" type="number"
                                        step="0.01" class="block w-full pr-12" :value="old('jarak_antar_klip5')" required
                                        placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        blade
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('jarak_antar_klip5')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="visual" :value="__('Visual')" />
                                <select id="visual" name="visual"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    {{-- <option value="">-- Pilih visual --</option> --}}
                                    <option value="OK" {{ old('visual') == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NG" {{ old('visual') == 'NG' ? 'selected' : '' }}>NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('visual')" />
                            </div>

                            <div>
                                <x-input-label for="kerapatan" :value="__('Kerapatan')" />
                                <select id="kerapatan" name="kerapatan"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    {{-- <option value="">-- Pilih kerapatan --</option> --}}
                                    <option value="OK" {{ old('kerapatan') == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NG" {{ old('kerapatan') == 'NG' ? 'selected' : '' }}>NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('kerapatan')" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    {{-- <option value="">-- Pilih status --</option> --}}
                                    <option value="OK" {{ old('status') == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NG" {{ old('status') == 'NG' ? 'selected' : '' }}>NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
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
                                            <option value="BENDING TIDAK PRESS">BENDING TIDAK PRESS</option>
                                            <option value="BLADE PECAH/SOBEK">BLADE PECAH/SOBEK</option>
                                            <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS
                                            </option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="JARAK DURI/BLADE">JARAK DURI/BLADE</option>
                                            <option value="JUMLAH SPIRAL OUT">JUMLAH SPIRAL OUT</option>
                                            <option value="KARAT">KARAT</option>
                                            <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                                            <option value="LEBAR BLADE OUT">LEBAR BLADE OUT</option>
                                            <option value="PANJANG BLADE OUT">PANJANG BLADE OUT</option>
                                            <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                                            <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                                            <option value="PISAU POUNCH TUMPUL">PISAU POUNCH TUMPUL</option>
                                            <option value="TEBAL BLADE OUT">TEBAL BLADE OUT</option>
                                            <option value="TRIMING">TRIMING</option>
                                            <option value="WHITE RUST">WHITE RUST</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="detail_description2_0" :value="__('Description 2')" />
                                        <select id="detail_description2_0" name="detail_description2[]"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="BENDING TIDAK PRESS">BENDING TIDAK PRESS</option>
                                            <option value="BLADE PECAH/SOBEK">BLADE PECAH/SOBEK</option>
                                            <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS
                                            </option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="JARAK DURI/BLADE">JARAK DURI/BLADE</option>
                                            <option value="JUMLAH SPIRAL OUT">JUMLAH SPIRAL OUT</option>
                                            <option value="KARAT">KARAT</option>
                                            <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                                            <option value="LEBAR BLADE OUT">LEBAR BLADE OUT</option>
                                            <option value="PANJANG BLADE OUT">PANJANG BLADE OUT</option>
                                            <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                                            <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                                            <option value="PISAU POUNCH TUMPUL">PISAU POUNCH TUMPUL</option>
                                            <option value="TEBAL BLADE OUT">TEBAL BLADE OUT</option>
                                            <option value="TRIMING">TRIMING</option>
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
                            <a href="{{ route('inspeksi_klip.show', $inspeksiKlip->id) }}"
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
                    <option value="BENDING TIDAK PRESS">BENDING TIDAK PRESS</option>
                    <option value="BLADE PECAH/SOBEK">BLADE PECAH/SOBEK</option>
                    <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS</option>
                    <option value="DIAMETER OUT">DIAMETER OUT</option>
                    <option value="JARAK DURI/BLADE">JARAK DURI/BLADE</option>
                    <option value="JUMLAH SPIRAL OUT">JUMLAH SPIRAL OUT</option>
                    <option value="KARAT">KARAT</option>
                    <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                    <option value="LEBAR BLADE OUT">LEBAR BLADE OUT</option>
                    <option value="PANJANG BLADE OUT">PANJANG BLADE OUT</option>
                    <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                    <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                    <option value="PISAU POUNCH TUMPUL">PISAU POUNCH TUMPUL</option>
                    <option value="TEBAL BLADE OUT">TEBAL BLADE OUT</option>
                    <option value="TRIMING">TRIMING</option>
                    <option value="WHITE RUST">WHITE RUST</option>
                </select>
            </div>
            <div>
                <label for="detail_description2_${index}" class="block text-sm font-medium text-gray-700">Description 2</label>
                <select id="detail_description2_${index}" name="detail_description2[]"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih Detail --</option>
                    <option value="BENDING TIDAK PRESS">BENDING TIDAK PRESS</option>
                    <option value="BLADE PECAH/SOBEK">BLADE PECAH/SOBEK</option>
                    <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS</option>
                    <option value="DIAMETER OUT">DIAMETER OUT</option>
                    <option value="JARAK DURI/BLADE">JARAK DURI/BLADE</option>
                    <option value="JUMLAH SPIRAL OUT">JUMLAH SPIRAL OUT</option>
                    <option value="KARAT">KARAT</option>
                    <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                    <option value="LEBAR BLADE OUT">LEBAR BLADE OUT</option>
                    <option value="PANJANG BLADE OUT">PANJANG BLADE OUT</option>
                    <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                    <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                    <option value="PISAU POUNCH TUMPUL">PISAU POUNCH TUMPUL</option>
                    <option value="TEBAL BLADE OUT">TEBAL BLADE OUT</option>
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
