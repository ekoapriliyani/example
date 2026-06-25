<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Inspeksi Baru') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">

                <div class="bg-indigo-600 px-8 py-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-white">Pencatatan Inspeksi PVC/HDPE</h2>
                    <p class="text-sm text-indigo-100 mt-1">
                        Silakan masukkan header Inspeksi PVC/HDPE.
                    </p>
                </div>

                <div class="p-8 text-gray-900">
                    <form action="{{ route('inspeksi_pvc.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Informasi Operasional
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi (Otomatis)')" />
                                    <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                        class="mt-1 block w-full bg-gray-200 text-gray-600 cursor-not-allowed py-3"
                                        value="{{ $nextNomor }}" readonly />
                                </div>
                                <div>
                                    <x-input-label for="tanggal" :value="__('Tanggal')" />
                                    <x-text-input id="tanggal" name="tanggal" type="date"
                                        class="mt-1 block w-full py-3"
                                        value="{{ old('tanggal', now()->format('Y-m-d')) }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                                </div>
                                <div>
                                    <x-input-label for="shift" :value="__('Shift')" />
                                    <select id="shift" name="shift"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3"
                                        required>
                                        <option value="">-- Pilih Shift --</option>
                                        <option value="1" {{ old('shift') == '1' ? 'selected' : '' }}>Shift 1
                                        </option>
                                        <option value="2" {{ old('shift') == '2' ? 'selected' : '' }}>Shift 2
                                        </option>
                                        <option value="3" {{ old('shift') == '3' ? 'selected' : '' }}>Shift 3
                                        </option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('shift')" />
                                </div>
                                <div>
                                    <x-input-label for="mesin_id" :value="__('Mesin')" />
                                    <select id="mesin_id" name="mesin_id" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3">
                                        <option value="">-- Pilih Mesin --</option>
                                        @foreach ($mesins as $mesin)
                                            <option value="{{ $mesin->id }}"
                                                {{ old('mesin_id') == $mesin->id ? 'selected' : '' }}>
                                                {{ $mesin->mesin_id }} - {{ $mesin->nama_mesin }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('mesin_id')" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Data Production Order
                                (PRO)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="pro_id" :value="__('PRO Number')" />
                                    <select id="pro_id" name="pro_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3"
                                        required>
                                        <option value="">-- Cari dan Pilih PRO --</option>
                                        @foreach ($pros as $pro)
                                            <option value="{{ $pro->id }}"
                                                {{ old('pro_id') == $pro->id ? 'selected' : '' }}>
                                                {{ $pro->pro_id }} - {{ $pro->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('pro_id')" />
                                </div>
                                <div>
                                    <x-input-label for="pro_description" :value="__('Description')" />
                                    <x-text-input id="pro_description" type="text"
                                        class="mt-1 block w-full bg-gray-200 text-gray-600 cursor-not-allowed py-3"
                                        value="{{ old('pro_description') }}" readonly />
                                </div>
                                <div>
                                    <x-input-label for="pro_qty" :value="__('Qty Ordered')" />
                                    <x-text-input id="pro_qty" type="text"
                                        class="mt-1 block w-full bg-gray-200 text-gray-600 cursor-not-allowed py-3"
                                        value="{{ old('pro_qty') }}" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Spesifikasi Material</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="d_kawat_inti" :value="__('Diameter Kawat Inti')" />
                                    <select id="d_kawat_inti" name="d_kawat_inti"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3">
                                        <option value="">-- Pilih Diameter --</option>
                                        @foreach (['1.6', '1.8', '2', '2.2', '2.5', '2.7', '3', '3.2', '3.4', '4'] as $d)
                                            <option value="{{ $d }}"
                                                {{ old('d_kawat_inti') == $d ? 'selected' : '' }}>{{ $d }}
                                                mm</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('d_kawat_inti')" />
                                </div>

                                <div>
                                    <x-input-label for="d_kawat_pvc" :value="__('Diameter Kawat PVC/HDPE')" />
                                    <x-text-input id="d_kawat_pvc" name="d_kawat_pvc" type="number" step="0.01"
                                        class="mt-1 block w-full py-3" :value="old('d_kawat_pvc')" placeholder="Contoh: 3.50" />
                                    <x-input-error class="mt-2" :messages="$errors->get('d_kawat_pvc')" />
                                </div>

                                <div>
                                    <x-input-label for="type_coating" :value="__('Type Kawat (Coating)')" />
                                    <select id="type_coating" name="type_coating"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3">
                                        <option value="">-- Pilih Type --</option>
                                        @foreach (['EP', 'LG', 'HG', 'Bezilum Class 1', 'Bezilum Class 2', 'Bezilum Class 3'] as $type)
                                            <option value="{{ $type }}"
                                                {{ old('type_coating') == $type ? 'selected' : '' }}>
                                                {{ $type }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('type_coating')" />
                                </div>

                                <div>
                                    <x-input-label for="type_lapisan" :value="__('Type Lapisan')" class="mb-2" />
                                    <div class="grid grid-cols-2 gap-4 mt-1">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="type_lapisan" value="PVC"
                                                class="peer sr-only"
                                                {{ old('type_lapisan') == 'PVC' ? 'checked' : '' }}>
                                            <div
                                                class="text-center px-4 py-3 border border-gray-300 rounded-lg peer-checked:bg-indigo-50 peer-checked:border-indigo-600 peer-checked:text-indigo-700 hover:bg-gray-50 transition-all font-medium">
                                                PVC
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="type_lapisan" value="HDPE"
                                                class="peer sr-only"
                                                {{ old('type_lapisan') == 'HDPE' ? 'checked' : '' }}>
                                            <div
                                                class="text-center px-4 py-3 border border-gray-300 rounded-lg peer-checked:bg-indigo-50 peer-checked:border-indigo-600 peer-checked:text-indigo-700 hover:bg-gray-50 transition-all font-medium">
                                                HDPE
                                            </div>
                                        </label>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('type_lapisan')" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
                            <div class="md:w-1/2">
                                <x-input-label for="total_prod" :value="__('Total Produksi (Diisi di akhir shift)')"
                                    class="text-yellow-800 font-semibold mb-1" />
                                <div class="flex items-center space-x-3 mt-1">
                                    <div class="relative flex-1">
                                        <x-text-input id="total_prod" name="total_prod" type="number"
                                            step="0.01" class="block w-full py-3" value="{{ old('total_prod') }}"
                                            placeholder="0.00" />
                                    </div>
                                    <div class="w-1/3">
                                        <select id="satuan" name="satuan"
                                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-3">
                                            @foreach (['unit', 'pcs', 'kg', 'roll', 'lembar', 'ton'] as $sat)
                                                <option value="{{ $sat }}"
                                                    {{ old('satuan') == $sat ? 'selected' : '' }}>{{ $sat }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('total_prod')" />
                                <x-input-error class="mt-2" :messages="$errors->get('satuan')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('inspeksi_pvc.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                {{ __('Simpan Inspeksi') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pro_id').select2({
                placeholder: '-- Pilih PRO --',
                allowClear: true,
                width: '100%'
            });

            $('#mesin_id').select2({
                placeholder: '-- Pilih Mesin --',
                allowClear: true,
                width: '100%'
            });

            async function loadProDetail(proId) {
                const descriptionInput = document.getElementById('pro_description');
                const qtyInput = document.getElementById('pro_qty');

                descriptionInput.value = '';
                qtyInput.value = '';

                if (!proId) return;

                try {
                    const response = await fetch(`/pro/${proId}/detail`);
                    const data = await response.json();

                    descriptionInput.value = data.description ?? '';
                    qtyInput.value = data.qty ?? '';
                } catch (error) {
                    console.error('Gagal mengambil detail PRO:', error);
                }
            }

            $('#pro_id').on('change', function() {
                loadProDetail($(this).val());
            });

            @if (old('pro_id'))
                loadProDetail("{{ old('pro_id') }}");
            @endif
        });
    </script>
</x-app-layout>
