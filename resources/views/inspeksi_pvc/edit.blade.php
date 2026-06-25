<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Inspeksi') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">

                <div class="bg-amber-600 px-8 py-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-white">Edit Header Inspeksi PVC</h2>
                    <p class="text-sm text-amber-100 mt-1">
                        Perbarui detail header untuk record inspeksi PVC.
                    </p>
                </div>

                <div class="p-8 text-gray-900">
                    <form action="{{ route('inspeksi_pvc.update', $inspeksi_pvc->id) }}" method="POST"
                        class="space-y-8">
                        @csrf
                        @method('PUT')
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Informasi Operasional
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi (Otomatis)')" />
                                    <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                        class="mt-1 block w-full bg-gray-200 text-gray-600 cursor-not-allowed py-3"
                                        value="{{ old('nomor_inspeksi', $inspeksi_pvc->nomor_inspeksi) }}" readonly />
                                </div>
                                <div>
                                    <x-input-label for="tanggal" :value="__('Tanggal Inspeksi')" />
                                    <x-text-input id="tanggal" name="tanggal" type="date"
                                        class="mt-1 block w-full py-3"
                                        value="{{ old('tanggal', $inspeksi_pvc->tanggal) }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                                </div>
                                <div>
                                    <x-input-label for="shift" :value="__('Shift')" />
                                    <select id="shift" name="shift"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3"
                                        required>
                                        <option value="">-- Pilih Shift --</option>
                                        <option value="1"
                                            {{ old('shift', $inspeksi_pvc->shift) == '1' ? 'selected' : '' }}>Shift 1
                                        </option>
                                        <option value="2"
                                            {{ old('shift', $inspeksi_pvc->shift) == '2' ? 'selected' : '' }}>Shift 2
                                        </option>
                                        <option value="3"
                                            {{ old('shift', $inspeksi_pvc->shift) == '3' ? 'selected' : '' }}>Shift 3
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
                                                {{ old('mesin_id', $inspeksi_pvc->mesin_id) == $mesin->id ? 'selected' : '' }}>
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
                                        <option value="">-- Pilih PRO --</option>
                                        @foreach ($pros as $pro)
                                            <option value="{{ $pro->id }}"
                                                data-description="{{ $pro->description }}"
                                                {{ old('pro_id', $inspeksi_pvc->pro_id) == $pro->id ? 'selected' : '' }}>
                                                {{ $pro->pro_id }} - {{ $pro->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('pro_id')" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="description" :value="__('Description')" />
                                    <x-text-input id="description" type="text"
                                        class="mt-1 block w-full bg-gray-200 text-gray-600 cursor-not-allowed py-3"
                                        value="{{ old('description', optional($inspeksi_pvc->pro)->description) }}"
                                        readonly />
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Spesifikasi Material</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="d_kawat_inti" :value="__('Diameter Kawat Inti')" />
                                    <select id="d_kawat_inti" name="d_kawat_inti" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3">
                                        <option value="">-- Pilih Diameter --</option>
                                        @foreach (['1.6', '1.8', '2', '2.2', '2.5', '2.7', '3', '3.2', '3.4', '4'] as $d)
                                            <option value="{{ $d }}"
                                                {{ old('d_kawat_inti', $inspeksi_pvc->d_kawat_inti) == $d ? 'selected' : '' }}>
                                                {{ $d }} mm</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('d_kawat_inti')" />
                                </div>

                                <div>
                                    <x-input-label for="d_kawat_pvc" :value="__('Diameter Kawat PVC')" />
                                    <x-text-input id="d_kawat_pvc" name="d_kawat_pvc" type="text"
                                        class="mt-1 block w-full py-3"
                                        value="{{ old('d_kawat_pvc', $inspeksi_pvc->d_kawat_pvc) }}"
                                        placeholder="0.00" />
                                    <x-input-error class="mt-2" :messages="$errors->get('d_kawat_pvc')" />
                                </div>

                                <div>
                                    <x-input-label for="type_coating" :value="__('Type Coating')" />
                                    <select id="type_coating" name="type_coating" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3">
                                        <option value="">-- Pilih Type Coating --</option>
                                        @foreach (['EP', 'LG', 'HG', 'Bezilum Class 1', 'Bezilum Class 2', 'Bezilum Class 3'] as $type)
                                            <option value="{{ $type }}"
                                                {{ old('type_coating', $inspeksi_pvc->type_coating) == $type ? 'selected' : '' }}>
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
                                                {{ old('type_lapisan', $inspeksi_pvc->type_lapisan ?? 'PVC') == 'PVC' ? 'checked' : '' }}>
                                            <div
                                                class="text-center px-4 py-3 border border-gray-300 rounded-lg peer-checked:bg-indigo-50 peer-checked:border-indigo-600 peer-checked:text-indigo-700 hover:bg-gray-50 transition-all font-medium">
                                                PVC
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="type_lapisan" value="HDPE"
                                                class="peer sr-only"
                                                {{ old('type_lapisan', $inspeksi_pvc->type_lapisan) == 'HDPE' ? 'checked' : '' }}>
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
                                            step="0.01" class="block w-full py-3"
                                            value="{{ old('total_prod', $inspeksi_pvc->total_prod) }}"
                                            placeholder="0.00" />
                                    </div>
                                    <div class="w-1/3">
                                        <select id="satuan" name="satuan"
                                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-3">
                                            @foreach (['unit', 'pcs', 'kg', 'roll', 'lembar', 'ton'] as $sat)
                                                <option value="{{ $sat }}"
                                                    {{ old('satuan', $inspeksi_pvc->satuan) == $sat ? 'selected' : '' }}>
                                                    {{ $sat }}</option>
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
                                class="inline-flex items-center px-6 py-3 bg-amber-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-amber-700 focus:bg-amber-700 active:bg-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                {{ __('Update Inspeksi') }}
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

            function updateDescription() {
                let selected = $('#pro_id').find(':selected');
                let desc = selected.data('description') || '';
                $('#description').val(desc);
            }

            updateDescription();

            $('#pro_id').on('change', function() {
                updateDescription();
            });
        });
    </script>

    {{-- mesin --}}
    <script>
        $('#mesin_id').select2({
            placeholder: '-- Pilih Mesin --',
            allowClear: true,
            width: '100%'
        });
    </script>

    {{--  --}}
    <script>
        $('#product_pvc_ref_id').select2({
            placeholder: '-- Pilih Product pvc --',
            allowClear: true,
            width: '100%'
        });
    </script>
</x-app-layout>
